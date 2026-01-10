@extends('layouts.layout')
@section('title', '::.Process Pending Sales')
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

@if(count($orders) == 0)
    <div class="col-md-9">
    <h1>Cart is empty</h1>
    </div>
@else
    <div class="col-md-9">

        <div class="row">

        <div class="col-md-12">
            <h1>Pending Sales</h1>

            <div class="m-t-sm">
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
                    @foreach($orders as $key=>$order)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$order['i_name']}}</td>
                        <td>{{$order['qty']}}</td>
                        <td>{{$order['price_total']}}
                        <input type="hidden" id="id-add-item" value="{{$order['id']}}" />
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" align="right"><strong>Total</strong></td>
                        <td><strong>{{$price_total}}</strong>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="form-group form-group-sm">
                    <!-- <button class="btn btn-danger btn-rounded btn-block" id="add-to-cart" type="submit">Checkout</button> -->
                </div>

            </div>

        </div>
        
        
            
        </div>
        <!-- end row -->
        

        <div class="row">

            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                            <!-- <i class="pe pe-7s-global text-warning"> </i> -->
                            <!-- Returned Items -->
                        </h1>
                        <div class="small">
                            
                        </div>
                        <div class="m-t-sm">

                        <form id="sales-checkout-form" action="{{url('sales/checkout/'.$transaction_ref)}}" method="post">
                        {{csrf_field()}}
                            <div class=" form-inline">

                                <div class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="total" id="sales-total" title="Total"  readonly="readonly" value="{{$price_total}}" />
                                    <span class="help-block small">Total</span>
                                </div>
                                <div class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="amount" id="sales-paid" title="Amount Paid" required="required" value="{{ old('amount') }}" />
                                    <span class="help-block small">Amount Paid</span>
                                </div>

                                <div id="method-payment" class="form-group form-group-sm">
                                    <select id="sales-method-payment" class="input-sm" name="payment_method" title="Select" required="required" >
                                        {{-- <option value="">Select</option> --}}
                                        <option value="cash" selected="selected">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="cash_bank_transfer">Cash + Bank Transfer</option>
                                        <option value="goods_transfer">Goods Transfer</option>
                                    </select>
                                <span class="help-block small">Mode of Payment</span>
                                </div>

                                <div id="discount" class="form-group form-group-sm">
                                    <select id="sales-discount" class="input-sm" name="discount" title="Select" >
                                        <option value="">Select</option>
                                        <option value="1">Discount</option>
                                        <option value="2">Debtor</option>
                                        {{-- <option value="3">Goods Transfer</option> --}}
                                    </select>
                                <span class="help-block small">Debtor/Discount</span>
                                </div>

                                <div class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="name" id="check-quantity-bottle" title="Customer name" required="required" value="{{ old('name') }}" />
                                    <span class="help-block small">Name on receipt</span>
                                </div>
                                

                                <div id="sales-paid-cash" class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="cash" id="sales-cash-paid" title="Cash Paid" value="{{ old('cash') }}" />
                                    <span class="help-block small">Amount Paid (Cash)</span>
                                </div>

                                <div id="sales-paid-bank" class="form-group form-group-sm">
                                    <input class="input-sm" type="text" name="bank" id="sales-bank-paid" title="Amount Paid (Bank Transfer)" value="{{ old('bank') }}" />
                                    <span class="help-block small">Amount Paid (Bank Transfer)</span>
                                </div>


                                <input class="input-sm" type="hidden" name="d_name" id="check-quantity-is-rgb" readonly="readonly" value="{{$d_name}}" />

                            </div>

                            <div class="form-group form-group-sm">
                                <button class="btn btn-danger btn-rounded btn-block" id="sales-checkout" type="submit">Checkout</button>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->



    </div>
@endif
    <!-- end main col-8 -->


    <div class="col-md-3">
        <!-- <div class="panel">
            <div class="panel-body">

            </div>
        </div> -->
    </div>
</div>
<!-- end main row -->


    </div>
</section>

@endsection