@extends('layouts.layout')
@section('title', '::.Customer')
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

        
        <form method="post" action="{{url('customer/edit/'.$customer['id'])}}">
         {{ csrf_field() }}
        <div class="row modal-row">


        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="c_name" id="edit-customer-name" placeholder="Customer Name" title="Customer Name" value="{{$customer['c_name']}}" />
                </div>
            </div>
            <span class="help-block small">Customer Name</span>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="phone" id="edit-customer-phone" placeholder="Phone Number" title="Customer Phone Number" value="{{$customer['phone']}}" />
                </div>
            </div>
            <span class="help-block small">Customer Phone Number</span>
        </div>
        <div class="panel-body">
            <div class="">
                <div class=form-group>
                <textarea name="address" id="edit-customer-address" placeholder="Address" title="Customer Address">{{$customer['address']}}</textarea>
                </div>
            </div>
            <span class="help-block small">Customer Address</span>
        </div>


        </div>

        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            <button type="submit" class="btn btn-danger btn-recharge" id="edit-customer-save" >Save</button>
            <button type="reset" class="btn btn-modal-save pull-left" >Cancel</button>
        </div>

        </form>
        </div>
        </section>
@endsection