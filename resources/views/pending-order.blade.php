@extends('layouts.layout')
@section('title', '::.Pending Order')
@section('content')


<section class="content bg-default">
    <div class="container-fluid">

    <!-- Display Validation Errors -->
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



<div class="row">

    <div class="col-md-9">



        <div class="row">

            <div class="col-md-12">
                <div class="panel">
                    <!-- <div class="panel-body"> -->
                        <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                            <i class="pe pe-7s-cart text-warning"> </i>
                            Pending Orders
                        </h1>
                        @if(count($pending_orders) == 0)
                        <div class="small">
                            <h3>No data to display</h3>
                        </div>
                        @else
                        @foreach($pending_orders as $porder)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel">
                                    <div class="panel-body">
                                        <p>Item : {{$porder['i_name']}} <br />
                                        Transaction Ref : {{$porder['transaction_ref']}} 
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-default" href="{{url('pending/'.$porder['id'])}}">Process</a>
                            </div>
                        </div>
                        @endforeach
                        <div class="m-t-sm">
                          
                        </div>
                        @endif
                    <!-- </div> -->
                </div>
            </div>

        </div>
        <!-- end row -->

    </div>
    <!-- end main col-8 -->


    <div class="col-md-3">
        <div class="panel">
            <div class="panel-body">
                <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                    <!-- <i class="pe pe-7s-global text-warning"> </i> -->
                    Info
                </h1>
                <div class="small">
                    <p>
                        This page enables you to process items returned by your drivers
                    </p>
                </div>
                <div class="m-t-sm">
                  
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main row -->


    </div>
</section>

@endsection