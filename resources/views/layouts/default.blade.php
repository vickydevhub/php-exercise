<!doctype html>
<html>
<head>
 <title>Php Exercise</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
   
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
</head>
<body>
<div class="container">
   
   <div id="main" class="row">
           @yield('content')
   </div>
   <footer class="row">
   
   </footer>
</div>
</body>
<script>
  $( function() {
    
    $("#searchForm").validate({
        rules: {
                email: {
                        required: true,
                        email: true 
                    },
                company_symbol:{
                        required: true,
                    },
                start_date:{
                        required: true,
                },
                end_date:{
                        required: true,
                }         
                },
        messages: {
			 
			email: {
				required: "Please enter email address",
				email: "Please enter a valid email address, example: you@yourdomain.com",
				  
			},
            company_symbol:{
                        required: "Please select company symbol",
                    },
            start_date:{
                    required: "Please select start date",
            },
            end_date:{
                    required: "Please select end date",
            }
		},
        submitHandler: function(form) {
            form.submit();
        }
    });
    var dateFormat = "yy-mm-dd",
      from = $( "#from" )
        .datepicker({
          dateFormat: 'yy-mm-dd'  ,
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        dateFormat: 'yy-mm-dd'  ,
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( "yy-mm-dd", element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>
  <style>
      label.error {
    color: red;
}
</style>
@stack('scripts')
</html>