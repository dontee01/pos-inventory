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

        <div class="col-md-3">
            <div class="panel">
                <div class="panel-body">
                    <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                        <i class="pe pe-7s-global text-warning"> </i>
                        
                    </h1>
                    <div class="small">

                    </div>
                    <div class="m-t-sm">
                      
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <h1>Inventory App</h1>

                <div class="m-t-sm">
                @if(count($cart) == 0)
                <div class="small">
                Cart is empty
                </div>
                @else
                <table class="table table-hover table-striped" id="table-custom">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{$cart['i_name']}}</td>
                        <td>{{$cart['qty']}}</td>
                        <td>{{$cart['price_total']}}
                        <input type="hidden" id="id-add-item" value="{{$cart['id']}}" />
                        </td>
                    </tr>

                    </tbody>
                </table>

                <div class="form-group form-group-sm">
                    <!-- <button class="btn btn-danger btn-rounded btn-block" id="add-to-cart" type="submit">Checkout</button> -->
                </div>
                @endif

                </div>

        </div>
        
        
            
        </div>
        <!-- end row -->


        <div class="row">

            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                            <i class="pe pe-7s-global text-warning"> </i>
                            Returned Items
                        </h1>
                        <div class="small">
                            
                        </div>
                        <div class="m-t-sm">
                          
                        <form action="{{url('cart/checkout'.$cart['id'])}}" method="post">
                        {{csrf_field()}}
                            <div class=" form-inline">


                                @if ($cart['is_rgb'])
                                <div class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="quantity_bottle" id="check-quantity-bottle" title="Quantity" required="required" value="0" />
                                    <span class="help-block small">Empty Bottles Returned</span>
                                </div>

                                <div class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="quantity_content" id="check-quantity-content" title="Quantity" required="required" value="0" />
                                    <span class="help-block small">Bottles with Content Returned</span>
                                </div>
                                @endif

                                @if($cart['is_rgb'] == 0)
                                <div class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="qty" id="check-quantity-qty" title="Quantity Returned" required="required" value="0" />
                                    <span class="help-block small">Quantity Returned</span>
                                </div>
                                @endif
                                <input class="input-sm" type="hidden" name="is_rgb" id="check-quantity-is-rgb" readonly="readonly" value="{{$cart['is_rgb']}}" />

                            </div>

                            <div class="form-group form-group-sm">
                                <button class="btn btn-danger btn-rounded btn-block" id="add-to-cart" type="submit">Checkout</button>
                            </div>

                        </form>
                        </div>
                    </div>
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
                    <i class="pe pe-7s-global text-warning"> </i>
                    Ads
                </h1>
                <div class="small">
                Ads
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