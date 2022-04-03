<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PriceResource; 
use Mail,   Carbon\Carbon;;
use App\Mail\HistoricalDataMail;

class HomeController extends Controller
{
    public function search(Request $request){
        // Retrieve the validated input data...
        $validator = Validator::make($request->all(), [
            'company_symbol'    => 'required',
            'email'             => 'required|email',
            'start_date'        => 'required|date|before:tomorrow',
            'end_date'          => 'required|date|after_or_equal:start_date|before:tomorrow',
        ]);
         //if validation fails
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $symbol = $request->input('company_symbol');    
        //Find Historical data
        $url = "https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol=".$symbol."&region=US";
        
        $response = Http::acceptJson()->withHeaders([
                        'X-RapidAPI-Host' => 'yh-finance.p.rapidapi.com',
                        'X-RapidAPI-Key' => '6693da903cmsh6716b23647236e2p1b3ab6jsn32b9fcc8514b'
                    ])->get($url);
        
        $result = null;
          if($response->successful())  
          {
            $data = $response->body();
            $data = json_decode( $data ,true);
            //Transform json data to filterize array
            $result = json_decode(
                            json_encode(
                                (new PriceResource($data))
                                    ->toResponse(null)
                                    ->getData()
                                    ->data
                            ), 
                        true);
            //Create array for open close data that will pass to graph       
            $labels = $open = $close =[];
            foreach( $result as $res)
            {   
                if(isset($res['open']) && isset($res['close']))
                {  
                    $open []=  array(
                                        'x'=> Carbon::parse($res['date'])->format('Y-m-d'), 'y'=>$res['open']
                                        ) ;
                    $close []=  array(
                        'x'=> Carbon::parse($res['date'])->format('Y-m-d'), 'y'=>$res['close']
                        ) ;                
                    $labels[]=  Carbon::parse($res['date'])->format('Y-m-d');
                }
                    
            }   
            $datasets = array(
                    array(
                        "label"=> "Open",
                        "backgroundColor"=> "#fff",
                        "borderWidth"=> 1,
                        "pointBorderWidth"=> 1,
                        "borderColor"=> "#f00",
                        "data"=> $open,
                        "fill"=> false,
                        "borderColor"=> 'red'
                        )
                    ,
                    array(
                        "label"=> "Close",
                        "borderWidth"=> 1,
                        "pointBorderWidth"=> 0,
                        "backgroundColor"=> "#fff",
                        "data"=>  $close ,
                        "fill"=> false,
                        "borderColor"=> 'blue'
                    )
                
                
                        );
            //Chart.js Line Chart with dynamic data             
            $chartjs = app()->chartjs
                    ->name('barChartTest')
                    ->type('line')
                    ->size(['width' => 1000, 'height' => 500])
                    
                    ->datasets(  $datasets )
            ->options([]);
            
            $chartjs->optionsRaw("{
                
                plugins: {
                zoom: {
                    limits: {
                    y: {min: 0, max: 10},
                    y2: {min: -5, max: 5}
                    },
                }
                }
            }");    
          }
                  
        //Mail data used fors ending mail  
        $mailData = [
            'subject' => $request->input('company_name'), 
            'body' => 'From '.$request->input('start_date').' to '.$request->input('end_date')
        ];
        //Send mail using Mail class HistoricalDataMail
        Mail::to($request->email)->send(new HistoricalDataMail($mailData));

         return view('data')
                    ->with(compact('result','symbol','chartjs'));
    }
}
