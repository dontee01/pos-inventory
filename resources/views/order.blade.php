@extends('layouts.layout')
@section('title', '::.Order')
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
                <!-- <div class="panel-body"> -->
                    <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                        <!-- <i class="pe pe-7s-global text-warning"> </i> -->
                        Products
                    </h1>
                    <div class="small">
                        <select class="input-sm" onchange="location = this.value;">
                            <option value="">Select an item</option>
                        @foreach($items as $item)
                            <option value="{{url('order/'.$item['id'])}}"">{{$item['i_name']}}</option>
                        @endforeach
                        </select>
                        <span class="help-block small">Choose a product</span>
                    </div>
                    <div class="m-t-sm">
                      
                    </div>
                <!-- </div> -->
            </div>
        </div>

        <div class="col-md-9" style="display:none;">
            <!-- <h1>Inventory App</h1> -->

            <div class=" form-inline">
                <div class="form-group form-group-sm">
                <select class="input-sm " title="Select a customer" name="customer">
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{$customer->c_name}}">{{$customer->c_name}}</option>
                    @endforeach
                </select>
                <span class="help-block small">Choose a customer</span>
                </div>

                <div class="form-group form-group-sm">
                    <input class="input-sm" type="text" name="quantity-bottle" id="add-quantity-bottle" title="Quantity" readonly="readonly" />
                    <span class="help-block small">Empty Bottles Left</span>
                </div>

                <div class="form-group form-group-sm">
                    <input class="input-sm" type="text" name="quantity-content" id="add-quantity-content" title="Quantity" readonly="readonly" />
                    <span class="help-block small">Bottles with Content Left</span>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <input class="input-sm" type="text" name="quantity" id="add-quantity" placeholder="Quantity" title="Quantity" />
                <span class="help-block small">Quantity</span>
            </div>

            <!-- <div class="form-group form-group-sm">
                <button class="btn btn-default btn-rounded btn-block" id="add-to-cart" type="submit">Add To Cart</button>
            </div> -->
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
                    Ads
                </h1>
                <div class="small">
                <!-- Ads -->
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