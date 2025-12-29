@extends('layouts.layout')
@section('title', '::.Suppliers')
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

        
<div class="pull-right">
	<a href="{{url('supplier/add')}}" class="btn btn-default btn-rounded"><i class="fa fa-add"></i>Add Supplier</a>
</div>
<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>S/N</th>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($suppliers as $key=>$supplier)
    <tr>
        <td>{{$key + 1}}</td>
        <td>{{$supplier['s_name']}}</td>
        <td>{{$supplier['phone']}}</td>
        <td>{{$supplier['address']}}
        <input type="hidden" id="id-add-supplier" value="{{$supplier['id']}}" />
        </td>
        <td><a href="{{url('/supplier/edit/'.$supplier['id'])}}">Edit</a> | <a id="delete-add-supplier" data-toggle="modal" data-target="#deleteSupplierModal{{$supplier['id']}}" >Delete</a></td>
        <div class="modal fade" id="deleteSupplierModal{{$supplier['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                    <!-- <form method="post" id="compose-modal"> -->
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Delete Supplier</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete?
                        </div>
                        <div class="modal-footer">
        <form method="post" action="{{url('/supplier/delete/'.$supplier['id'])}}">
         {{ csrf_field() }}

                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                            <button type="submit" class="btn btn-danger btn-recharge" id="delete-notification-confirm" >Delete</button>
                            
                            <button type="button" class="btn btn-modal-save pull-left"
                                    data-dismiss="modal" >Cancel</button>
        </form>
                        </div>
                    <!-- </form> -->
                    </div>
                </div>
            </div>
    </tr>
    @endforeach

    </tbody>
</table>
		</div>
		</section>
@endsection