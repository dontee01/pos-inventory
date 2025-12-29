@extends('layouts.layout')
@section('title', '::.Customers')
@section('content')


    <section class="content bg-default">
            <div class="container-fluid">

        <!-- Display Validation Errors -->
        @include('common.errors')

        @if (Session::has('flash_message'))
        <div class="alert alert-danger">
            <strong>{{Session::get('flash_message')}}</strong>

            <br><br>

        </div>
        @endif
<div class="pull-right">
	<a href="{{url('customer/add')}}" class="btn btn-default btn-rounded"><i class="fa fa-add"></i>Add Customer</a>
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
    @foreach($customers as $key=>$customer)
    <tr>
        <td>{{$key + 1}}</td>
        <td>{{$customer['c_name']}}</td>
        <td>{{$customer['phone']}}</td>
        <td>{{$customer['address']}}
        <input type="hidden" id="id-add-customer" value="{{$customer['id']}}" />
        </td>
        <td><a href="{{url('/customer/edit/'.$customer['id'])}}">Edit</a> | <a id="delete-add-customer" data-toggle="modal" data-target="#deleteCustomerModal{{$customer['id']}}" >Delete</a></td>
        <div class="modal fade" id="deleteCustomerModal{{$customer['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                    <!-- <form method="post" id="compose-modal"> -->
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Delete Customer</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete?
                        </div>
                        <div class="modal-footer">
        <form method="post" action="{{url('/customer/delete/'.$customer['id'])}}">
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