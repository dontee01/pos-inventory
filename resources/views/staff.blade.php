@extends('layouts.layout')
@section('title', '::.Users')
@section('content')


    <section class="content bg-default">
            <div class="container-fluid">

        <!-- Display Validation Errors -->
        
                    <div class="col-lg-12">

                        <!-- Display Validation Errors -->
                        @include('common.errors')

                        @if (Session::has('flash_message'))
                        <div align="center" class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" color="blue">&times;</button>
                            <strong>{{Session::get('flash_message')}}</strong>

                        </div>
                        @endif

                        @if (Session::has('flash_message_success'))
                        <div align="center" class="alert alert-success alert-dismissable ">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" color="blue">&times;</button>
                            <i class="fa fa-info-circle"></i><strong>{{Session::get('flash_message_success')}}</strong>

                        </div>
                        @endif

                    </div>
<div class="pull-right">
    <a href="{{url('user/add')}}" class="btn btn-default btn-rounded"><i class="fa fa-add"></i>Add User</a>
</div>
<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>S/N</th>
        <th>Username</th>
        <th>Level</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $key=>$user)
    <tr>
        <td>{{$key + 1}}</td>
        <td>{{$user['name']}}</td>
        <td>{{$user['level']}}
        <input type="hidden" id="id-add-user" value="{{$user['id']}}" />
        </td>
        <td><a href="{{url('/user/edit/'.$user['id'])}}">Edit</a> | <a id="delete-add-user" data-toggle="modal" data-target="#deleteUserModal{{$user['id']}}" >Delete</a></td>
        <div class="modal fade" id="deleteUserModal{{$user['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                    <!-- <form method="post" id="compose-modal"> -->
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Delete User</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete?
                        </div>
                        <div class="modal-footer">
        <form method="post" action="{{url('/user/delete/'.$user['id'])}}">
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