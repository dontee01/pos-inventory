@extends('layouts.layout')
@section('title', '::.Items')
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
	<a href="{{url('item/add')}}" class="btn btn-default btn-rounded"><i class="pe pe-7s-plus"></i>Add Item</a>
</div>
<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>S/N</th>
        <th>Category</th>
        <th>Item</th>
        <th>Content (Crates)</th>
        <th>Empty Bottles (Crates)</th>
        <th>Quantity (For Non-RGB)</th>
        <th>Unit Price</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
    <tr>
        <td>{{$key + 1}}</td>
        <td>{{$item['category']}}</td>
        <td>{{$item['i_name']}}</td>
        <td>
        @if ($item['is_rgb'] == 1)
        {{$item['qty_content']}}
        @endif
        </td>
        <td>
        @if ($item['is_rgb'] == 1)
        {{$item['qty_bottle']}}
        @endif
        </td>
        <td>
        @if ($item['is_rgb'] == 0)
        {{$item['qty']}}
        @endif
        </td>
        <td>{{$item['price_unit']}}
        <input type="hidden" id="id-add-item" value="{{$item['id']}}" />
        </td>
        <td><a href="{{url('/item/edit/'.$item['id'])}}">Edit</a> | <a id="delete-add-item" data-toggle="modal" data-target="#deleteItemModal{{$item['id']}}" >Delete</a></td>
        <div class="modal fade" id="deleteItemModal{{$item['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                    <!-- <form method="post" id="compose-modal"> -->
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Delete Item</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete?
                        </div>
                        <div class="modal-footer">
        <form method="post" action="{{url('/item/delete/'.$item['id'])}}">
         {{ csrf_field() }}

                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                            <button type="submit" class="btn btn-danger btn-recharge" id="delete-notification-confirm" >Delete</button>
                            <!-- <a id="delete-modal-item" href="{{url('/item/delete/'.$item['id'])}}" type="button" class="btn btn-danger btn-recharge" id="delete-notification-confirm" data-dismiss="modal" >Delete</a> -->
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