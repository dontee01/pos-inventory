@extends('layouts.layout')
@section('title', '::.Report')
@section('content')


<section class="content bg-default">
    <div class="container-fluid">

    <!-- Display Validation Errors -->
        @include('common.errors')

        @if (Session::has('flash_message'))
        <div align="center" class="alert alert-danger alert-dilgissable mw800 center-block">
            <button type="button" class="close" data-dilgiss="alert" aria-hidden="true" color="blue">x</button>
            <strong>{{Session::get('flash_message')}}</strong>

            <br><br>

        </div>
        @endif

        @if (Session::has('flash_message_success'))
        <div align="center" class="alert alert-success alert-dilgissable mw800 center-block">
            <button type="button" class="close" data-dilgiss="alert" aria-hidden="true" color="blue">x</button>
            <strong>{{Session::get('flash_message_success')}}</strong>

            <br><br>

        </div>
        @endif



<div class="row">

    <div class="col-lg-9">

        <div class="row">

        <div class="col-lg-12">
            <h4>Report</h4>

            <form action="{{url('report/show')}}" method="post">
            {{csrf_field()}}

                <div class=" form-inline">
 <!-- <input name="dayfrom" type="text" class="tcal" required="required" autocomplete="off" /> -->
                    <div class="form-group form-group-lg">
                        <div class='input-group date' id='datetimepicker6'>
                            <input type='text' class="input-lg" name="from" required="required" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    <span class="help-block lgall">Choose a date</span>
                    </div>

                    <div class="form-group form-group-lg">
                        <div class='input-group date' id='datetimepicker7'>
                            <input type='text' class="input-lg" name="to" required="required" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    <span class="help-block lgall">Choose a date <b>Click on the calendar icon</b></span>
                    </div>


                    <input class="input-lg" type="hidden" name="transaction_ref" id="add-quantity-is-rgb" readonly="readonly" value="{{Session::get('transaction_ref')}}" />

                </div>


                <div class="form-group form-group-lg">
                <select class="input-lg " title="How did the bottles break ?" name="report_type" required="required">
                    <option value="">Select Report Type</option>
                    <option value="sales">Sales Log</option>
                    <option value="purchases">Purchases</option>
                    <option value="bottle-log">Bottle Log</option>
                    <option value="stock">Stock</option>
                    <option value="orders">Orders Log</option>
                    {{-- <option value="debtors">Debtors Log</option> --}}
                </select>
                <span class="help-block lgall">What report type would you like to see ?</span>
                </div>


                <div class="form-group form-group-lg">
                    <button class="btn btn-default btn-rounded btn-block" id="add-to-cart" type="submit">Show</button>
                </div>

            </form>


        </div>
        
        
            
        </div>
        <!-- end row -->
    </div>
    <!-- end main col-8 -->


    <div class="col-lg-3">
        <!-- <div class="panel">
            <div class="panel-body">
                <h1 class="m-t-lg m-b-xs" style="margin-top: 30px">
                    <i class="pe pe-7s-global text-warning"> </i>
                    Ads
                </h1>
                <div class="lgall">
                Ads
                </div>
                <div class="m-t-lg">
                  
                </div>
            </div>
        </div> -->
    </div>
</div>
<!-- end main row -->


    </div>
</section>

@endsection