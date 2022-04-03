
 
@extends('layouts.default')
 
 
 @section('content')
 <h2>Historical quotes for the submitted Company {{$symbol}}  </h2>
<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Open</th>
      <th scope="col">High</th>
      <th scope="col">Low</th>
      <th scope="col">Close</th>
      <th scope="col">Volume</th>
    </tr>
  </thead>
  <tbody>
  @forelse ($result  as $res)
    @if(isset($res['open']) && isset($res['close']))
    <tr>
      <td>{{ \Carbon\Carbon::parse($res['date'])->format('Y-m-d') }}</td>
      <td>{{ $res['open']}}</td>
      <td>{{ $res['high'] }}</td>
      <td>{{ $res['low'] }}</td>
      <td>{{ $res['close'] }}</td>
      <td>{{ (isset($res['volume'])?$res['volume']:'N/A') }}</td>
    </tr>
    @endif
    @empty
    <tr colspan="6">No Records</tr>
    @endforelse
    
     
  </tbody>
</table>
 
<div style="width:100%;margin-top:50px;">
    <h2>Historical Charts based on Open and Close prices</h2>
    {!! $chartjs->render() !!}
</div>

 @endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
@endpush