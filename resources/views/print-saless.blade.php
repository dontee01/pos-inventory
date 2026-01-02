<!DOCTYPE html>
<html>
    <head>
        <title>{{ env('SITE_NAME') }}::.Print</title>

    <link href="{{ asset('vendor/fontawesome/css/font-awesome.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('vendor/animate.css/animate.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel='stylesheet' type='text/css' />
    <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel='stylesheet' type='text/css' />

    <link href="{{ asset('vendor/tcal.css') }}" rel='stylesheet' type='text/css' />



    <link href="{{ asset('styles/print-style.css') }}" rel='stylesheet' type='text/css' />

    <style type="text/css">
        .invoice-title h2, .invoice-title h3, .invoice-title h4 {
            display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }

        .container {
            margin-left: 2px;
            padding-left: 0px;
        }

        .table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td{
            padding: 1px;
        }

        body {
            font-size: 10px;
            line-height: normal;
        }
    </style>
        
    </head>
    <body>

        <div class="container">
        @include('common.errors')

            @if (Session::has('flash_message'))
            <div align="center" class="alert alert-danger alert-dismissable mw800 center-block">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" color="blue">x</button>
                <strong>{{Session::get('flash_message')}}</strong>

                <br><br>

            </div>
            @endif

            @if (Session::has('flash_message_success'))
            <div align="center" class="alert alert-success alert-dismissable mw800 center-block">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" color="blue">x</button>
                <strong>{{Session::get('flash_message_success')}}</strong>

                <br><br>

            </div>
            @endif
            <div id="print-content">
                <div class="row">
                    <div class="col-xs-8">
                        <div class="invoice-title">
                            <h4>Sahlat Ltd</h4><br />
                            <span class="pull-right"><strong>Receipt # {{ $receipt }} </strong></span>
                        </div>
                        <hr>
                        <div class="text-center">
                            62,Tinubu Street, Ita Eko Abk<br />
                            08067275241,08054942852
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <address>
                                {{-- <strong>Customer:</strong> --}}
                                    {{-- $r_name --}}<br />
                                    {{ date('Y-m-d') }}<br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-xs-8">
                        <!-- <div class="panel panel-default"> -->
                            <!-- <div class="panel-body"> -->
                                <!-- <div class="table-responsive"> -->
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <td><strong>Product</strong></td>
                                                <td class="text-center"><strong>Quantity</strong></td>
                                                <td class="text-right"><strong>Total(&#8358;)</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                            @foreach($cart_items as $key=>$cart)
                                            <tr>
                                                <td>{{ $cart['i_name'] }}</td>
                                                <td class="text-center">{{ $cart['qty'] }}</td>
                                                <td class="text-right">{{ $cart['price_total'] }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td class="thick-line">
                                                    <!-- Goods sold in good conditions are not returnable <br />
                                                    Thanks for your patronage -->
                                                </td>
                                                <td class="thick-line text-center"><strong>Grand Total</strong></td>
                                                <td class="thick-line text-right">&#8358;{{ $price_total }}</td>
                                            </tr>
                                            <tr>
                                                <td class="">

                                                </td>
                                                <td class="text-center"><strong>Amount Paid</strong></td>
                                                <td class="text-right">&#8358;{{ $amount_paid }}</td>
                                            </tr>
                                            <tr>
                                                <td class="">
                                                    
                                                </td>
                                                <td class="thick-line text-center">
                                                <strong>
                                                @if($is_discount == 1)
                                                    Discount
                                                @endif
                                                @if($is_discount == 2)
                                                    Debt
                                                @endif
                                                @if($is_discount == 0)
                                                    Balance
                                                @endif
                                                </strong></td>
                                                <td class="thick-line text-right">&#8358;{{ $difference }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-left">
                                                    <small>Goods sold in good conditions are not returnable <br />
                                                    Thanks for your patronage
                                                    </small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="thick-line text-center">
                                                    <span>Powered by  <br />
                                                    {{-- <strong>Smatox Technologies 0803 802 1699</strong> --}}
                                                    <strong>Acing Ltd. 0803 802 1699</strong>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <!-- </div> -->
                            <!-- </div> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8">

                    <div class="modal-footer" style="">

                        <a href="javascript:window.print()" class="btn btn-success">
                                            <i class="fa fa-print pr5"></i> Print</a>
                        <a class="btn btn-default" href="{{url('/sales')}}" >Close</a>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"> </script>

        <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"> </script>

    </body>
</html>
