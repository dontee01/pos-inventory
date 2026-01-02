@extends('layouts.layout')
@section('title', '::.Purchase Bottle')
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
            <h1>Purchase Empty Bottles</h1>

            <form action="{{url('purchase/bottle/add')}}" method="post">
            {{csrf_field()}}

                <div class=" form-inline">

                    <div class="form-group form-group-sm">
                        <select class="input-sm" name="item_id" title="Select an item" required="required">
                            <option value="">Select an item</option>
                        @foreach($items as $item)
                            <option value="{{$item['id']}}">{{$item['i_name']}}</option>
                        @endforeach
                        </select>
                    <span class="help-block small">Choose an Item</span>
                    </div>
                    
                    <div class="form-group form-group-sm">
                    <select class="input-sm " title="Select a supplier" name="supplier" required="required">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{$supplier->s_name}}">{{$supplier->s_name}}</option>
                        @endforeach
                    </select>
                    <span class="help-block small">Choose a supplier</span>
                    </div>

                    
                    <input class="input-sm" type="hidden" name="transaction_ref" id="add-quantity-is-rgb" readonly="readonly" value="{{Session::get('transaction_ref')}}" />

                </div>


                <div class="form-group form-group-sm">
                    <input class="input-sm" type="text" v-model="quantity" name="quantity" id="add-quantity" title="Quantity" required="required" />
                    <span class="help-block small">Quantity (Crates)</span>
                </div>

                <div class=" form-inline">

                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" v-model="price" name="price" id="add-quantity-price" title="Selling Price" required="required" />
                        <span class="help-block small">Selling Price</span>
                    </div>
                    
                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" v-model="cost_price" name="cost_price" id="cost-price" title="Cost Price" required="required" />
                        <span class="help-block small">Cost Price</span>
                    </div>

                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" name="amount_paid" id="add-quantity-paid" title="Amount Paid" required="required" />
                        <span class="help-block small">Amount Paid</span>
                    </div>

                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" name="sub_total" id="add-quantity-sub" title="Sub Total" readonly="readonly" value="@{{quantity * cost_price}}" required="required" />
                        <span class="help-block small">Sub Total</span>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <button class="btn btn-default btn-rounded btn-block" id="add-to-cart" type="submit">Add</button>
                </div>

            </form>


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