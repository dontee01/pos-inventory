@extends('layouts.layout')
@section('title', '::.Supplier')
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
        
        <form method="post" action="{{url('supplier/edit/'.$supplier['id'])}}">
         {{ csrf_field() }}
        <div class="row modal-row">


        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="s_name" id="edit-supplier-name" placeholder="Supplier Name" title="Supplier Name" value="{{$supplier['s_name']}}" />
                </div>
            </div>
            <span class="help-block small">Supplier Name</span>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="phone" id="edit-supplier-phone" placeholder="Phone Number" title="Supplier Phone Number" value="{{$supplier['phone']}}" />
                </div>
            </div>
            <span class="help-block small">Supplier Phone Number</span>
        </div>
        <div class="panel-body">
            <div class="">
                <div class=form-group>
                <textarea name="address" id="edit-supplier-address" placeholder="Address" title="Supplier Address">{{$supplier['address']}}</textarea>
                </div>
            </div>
            <span class="help-block small">Supplier Address</span>
        </div>


        </div>

        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            <button type="submit" class="btn btn-danger btn-recharge" id="edit-supplier-save" >Save</button>
            <button type="reset" class="btn btn-modal-save pull-left" >Cancel</button>
        </div>

        </form>
        </div>
        </section>
@endsection