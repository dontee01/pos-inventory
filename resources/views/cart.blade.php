@extends('layouts.layout')
@section('title', '::.Cart')
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
            <!-- <h1>Inventory App</h1> -->

                <div class="m-t-sm">
                @if(count($cart_items) == 0)
                <h3>
                Cart is empty
                </h3>
                @else
                <table class="table table-hover table-striped" id="table-custom">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Sub Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart_items as $key=>$cart)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$cart['i_name']}}</td>
                        <td>{{$cart['qty']}}</td>
                        <td>{{$cart['price_total']}}
                        <input type="hidden" id="id-add-item" value="{{$cart['id']}}" />
                        </td>
                        <td><a id="delete-cart-item" data-toggle="modal" data-target="#deleteCartModal{{$cart['id']}}" >Delete</a></td>
                        <div class="modal fade" id="deleteCartModal{{$cart['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <form method="post" action="{{url('/cart/delete/'.$cart['id'])}}">
                                         {{ csrf_field() }}

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

                <div class="form-group form-group-sm">

                    <form action="{{url('cart/checkout')}}" method="post">
                    {{csrf_field()}}
                     <!-- <a href="{{url('/cart/checkout/'.$cart['id'])}}">Checkout</a> -->
                        <input class="input-sm" type="hidden" name="cart_session" id="check-quantity-cart-session" readonly="readonly" value="{{Session::get('cart_session')}}" />
                        <button class="btn btn-danger btn-rounded btn-block" id="add-to-cart" type="submit">Checkout</button>

                    </form>
                </div>
                @endif

                </div>

        </div>
        
        
            
        </div>
        <!-- end row -->
    </div>
    <!-- end main col-8 -->


    <div class="col-md-3">
        <!-- <div class="panel">
            <div class="panel-body">
                <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                    <i class="pe pe-7s-global text-warning"> </i>
                    Ads
                </h1>
                <div class="small">
                Ads
                </div>
                <div class="m-t-sm">
                  
                </div>
            </div>
        </div> -->
    </div>
</div>
<!-- end main row -->


    </div>
</section>

@endsection