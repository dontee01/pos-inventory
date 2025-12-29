<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Page title -->
    <title>{{ env('SITE_NAME') }} @yield('title')</title>

    <!-- Vendor styles -->
    
    <link href="{{ asset('vendor/fontawesome/css/font-awesome.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('vendor/animate.css/animate.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel='stylesheet' type='text/css' />

    <link href="{{ asset('vendor/tcal.css') }}" rel='stylesheet' type='text/css' />



    <link href="{{ asset('styles/print-style.css') }}" rel='stylesheet' type='text/css' />

    <!-- App styles -->
    
    <link href="{{ asset('styles/pe-icons/pe-icon-7-stroke.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('styles/pe-icons/helper.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('styles/stroke-icons/style.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('styles/style.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('styles/bbn.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('styles/custom-components.css') }}" rel='stylesheet' type='text/css' />


    <link href="{{ asset('fontello/css/fontello.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('iconfont/material-icons.css') }}" rel='stylesheet' type='text/css' />

     <!--<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>-->
    <link href="{{ asset('images/logo.png') }}" rel="icon">
</head>
<body>

<!-- Wrapper-->
<div class="wrapper bg-default">

    <!-- Header-->
    @include('layouts.header.header')

    <!-- End header-->


    <!-- Navigation-->
    @include('layouts.header.nav')


    @include('modals.pos-help')

    <!-- End navigation-->

    <!-- Main content-->
    @yield('content')

    <!-- End main content-->

</div>
<!-- End wrapper-->

<div id="scrpt">
<!-- Vendor scripts -->


<script src="{{ asset('vendor/pacejs/pace.min.js') }}"> </script>

<script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"> </script>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"> </script>

<script src="{{ asset('vendor/toastr/toastr.min.js') }}"> </script>

<script src="{{ asset('vendor/sparkline/index.js') }}"> </script>

<script src="{{ asset('vendor/flot/jquery.flot.min.js') }}"> </script>

<script src="{{ asset('vendor/flot/jquery.flot.resize.min.js') }}"> </script>

<script src="{{ asset('vendor/flot/jquery.flot.spline.js') }}"> </script>


<script src="{{ asset('vendor/tcal.js') }}"> </script>

<script src="{{ asset('vendor/moment/moment.js') }}"> </script>

<script src="{{ asset('vendor/bootstrap/js/bootstrap-datetimepicker.min.js') }}"> </script>

<script src="{{ asset('js/app.js') }}"> </script>


<script src="{{ asset('scripts/luna.js') }}"> </script>

<!-- App scripts -->
<!-- <script src="scripts/luna.js"></script>

<script src="res/js/extra.js"></script>

<script src="res/js/extra-account.js"></script> -->

<!--<script src="res/js/messages.js"></script>-->

<!-- <script src="js/app.js"></script> -->

<script>

    $(document).ready(function($) {

        $('#rgb').hide();
        $('#log-staff').hide();

        $('#is-discount').prop('checked', false);
        $('#purchase-rebate').hide();

        $('#discount').show();
        $('#sales-paid').on('input', function(){
            total = parseFloat($('#sales-total').val());
            paid = parseFloat($('#sales-paid').val());
            diff = parseFloat( total - paid );
            // alert(diff);return;
            if (diff > 0)
            {
                $('#discount').show();
            }
            else
            {
                $('#discount').hide();
            }
        });

        $('#sales-checkout').on('click', function(e) {
            var difference = parseFloat( parseFloat($('#sales-total').val()) - parseFloat($('#sales-paid').val()) );
            // alert(difference);return;
            if (difference > 0)
            {
                if ($('#sales-discount').val() === '')
                {
                    alert('Discount cannot be empty');
                    e.preventDefault();
                    // return;
                }
            }
        });

        $('#is-discount').on('click', function() {
            if ($(this).prop('checked') == true )
            {
                // alert('Clicked');
                $('#purchase-rebate').show();
            }
            else
            {
                $('#purchase-rebate').hide();
            }

        });

        $('#purchase-add').on('click', function(e) {
            var rebate = $('#rebate-quantity').val();


            // var check = $('#is-rgb').prop('checked');
            // alert(check+' save Clicked '+bottle+' hj');

            if ($('#is-discount').prop('checked') == true )
            {
                if (rebate === '')
                {
                    alert('Rebate field is required');
                    e.preventDefault();
                    // return;
                }
            }
        });


        $('#add-product-is-rgb').on('click', function() {
            if ($(this).prop('checked') == true )
            {
                // alert('Clicked');
                $('#rgb').show();
                $('#nrgb').hide();
            }
            else
            {
                $('#rgb').hide();
                $('#nrgb').show();
            }

        });


        $('#is-rgb-staff').on('click', function() {
            if ($(this).prop('checked') == true )
            {
                // alert('Clicked');
                $('#log-staff').show();
                $('#log-driver').hide();
            }
            else
            {
                $('#log-staff').hide();
                $('#log-driver').show();
            }

        });

        $('#add-to-log').on('click', function(e) {
            var staff = $('#add-log-staff').val();
            var driver = $('#add-log-driver').val();


              // var check = $('#is-rgb').prop('checked');
              // alert(check+' save Clicked '+bottle+' hj');

            if ($('#is-rgb-staff').prop('checked') == false )
            {
                if (driver === '')
                {
                    alert('All Fields are required');
                    e.preventDefault();
                    // return;
                }
            }
            else if ($('#is-rgb-staff').prop('checked') == true )
            {
                if (staff === '')
                {
                    alert('All Fields are required');
                    e.preventDefault();
                }
            }
        });


        $('#add-product-save').on('click', function(e) {
            var content = $('#add-product-content').val();
            var bottle = $('#add-product-bottle').val();
            var qty = $('#add-product-qty').val();


            // var check = $('#is-rgb').prop('checked');
            // alert(check+' save Clicked '+bottle+' hj');

            if ($('#add-product-is-rgb').prop('checked') == false )
            {
                if (qty === '')
                {
                    alert('All Fields are required');
                    e.preventDefault();
                    // return;
                }
            }
            else if ($('#add-product-is-rgb').prop('checked') == true )
            {
                if (content === '' || bottle === '')
                {
                    alert('All Fields are required');
                    e.preventDefault();
                    // return;
                }
            }

        });

        $('#delete-add-item').on('click', function(e) {

        });

        $('#datetimepicker6').datetimepicker();
        
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });

    })
</script>
</div>
</body>

</html>