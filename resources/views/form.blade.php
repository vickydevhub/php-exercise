 
@extends('layouts.default')
 
 
@section('content')
<h2>Php Exercise</h2>
  <form class="col-sm-6" action="{{route('search')}}" id="searchForm" autocomplete="off">
  
      <!-- Email input -->
    <div class="form-outline mb-3 ">
    <label class="form-label" for="company_symbol">Company Symbol</label>
        <select id="company_symbol" name="company_symbol" class="form-control mb-3" >
        <option value="">Select company symbol</option>
        @forelse ($company_info as $info)
            <option value="{{ $info['Symbol'] }}">{{ $info['Company Name'] }}</option>
        @empty
        <option value="">No company</option>
        @endforelse
        </select> 
        <input type="hidden" name="company_name"  id="company_name"/>
        @error('company_symbol')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <!-- 2 column grid layout with text inputs for the first and last names -->
    <div class="row mb-3">
        <div class="col">
        <div class="form-outline">
            <label class="form-label" for="from">Start Date</label>
            <input type="text" id="from" class="form-control"  name="start_date" autocomplete="off"/>
            @error('start_date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>
        </div>
        <div class="col">
        <div class="form-outline">
        <label class="form-label" for="to">End Date</label>
            <input type="text" id="to" class="form-control" name="end_date" autocomplete="off"/>
            @error('end_date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>
        </div>
    </div>

       <!-- Email input -->
       <div class="form-outline mb-3 ">
       <label class="form-label" for="email">Email address</label>
        <input type="email" id="email" class="form-control mb-3" name="email" autocomplete="off"/>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
 
    <!-- Submit button -->
    <button type="submit" class="btn btn-primary btn-block mb-4">Search</button>
    </div>
    
    </form>
@endsection
@push('scripts')
 
  <script>
      $(document).ready( function () {
        $("body").on('change','#company_symbol',function() {
            if($(this).val() != "")  {
                $("#company_name").val($( "#company_symbol option:selected" ).text());
            }else{
                $("#company_name").val("");
            }
           
        });
    } );
</script>
@endpush