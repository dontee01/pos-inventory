@extends('layouts.layout')
@section('title', '::.Sales Report')
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
<div align="center">
    <h4>Sales Report</h4>
</div>
<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>Date</th>
        <th>Driver/Individual</th>
        <th>Receipt</th>
        <th>Customer</th>
        <th>Discount</th>
        <th>Payment Method</th>
        <th>Payment Cash</th>
        <th>Payment Bank</th>
        <th>Total Sales</th>
        <th>Difference</th>
        <th>Amount Paid</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
    <tr>
        <td>{{ date_create($item['created'])->format("j M Y, g:i a") }}</td>
        <td>{{$item['d_name']}}</td>
        <td>{{$item['receipt']}}</td>
        <td>{{$item['name']}}</td>
        <td>{{$item['discount']}}</td>
        <td>{{$item['payment_method']}}</td>
        <td>{{$item['amount_paid_cash']}}</td>
        <td>{{$item['amount_paid_bank']}}</td>
        <td>{{$item['total']}}
        <input type="hidden" id="id-add-item" value="{{$item['id']}}" />
        </td>
        <td>
        {{$item['difference']}}
        </td>
        <td>
        {{$item['amount_paid']}}
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="10" align="right">
        <strong>Grand Total Sales</strong>
        </td>
        <td>
        <strong>{{$total_sales}}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="10" align="right">
        <strong>Grand Total Paid</strong>
        </td>
        <td>
        <strong>{{$total_paid}}</strong>
        </td>
    </tr>
    </tbody>
</table>

<div align="center">
    <h4>Empty Bottles</h4>
</div>
<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>Date</th>
        <th>Transaction Ref</th>
        <th>Name</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Comment</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bottle_orders as $key=>$order)
    <tr>
        <td>{{ date_create($order['created'])->format("j M Y, g:i a") }}</td>
        <td>{{$order['transaction_ref']}}</td>
        <td>{{$order['d_name']}}</td>
        <td>{{$order['i_name']}}</td>
        <td>
        {{$order['qty']}}
        </td>
        <td>{{$order['price_unit']}}
        <input type="hidden" id="id-add-item" value="{{$order['id']}}" />
        </td>
        <td>
        {{$order['comment']}}
        </td>
        <td>
        {{$order['price_total']}}
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="7" align="right">
        <strong>Grand Total</strong>
        </td>
        <td>
        <strong>{{$price_total_bottle}}</strong>
        </td>
    </tr>
    </tbody>
</table>

        <div align="center" style='margin-top: 22px;color:#404041;text-align: center; font-size:12px;line-height:16px;border-bottom:solid 1px #e5e5e5'>
            <!-- <a class="btn btn-default" >Print</a>
            <a class="btn btn-default" >PDF</a> -->
            <a class="btn btn-default" href="{{url('/report')}}" >Close</a>
        </div>
        </div>
        </section>
@endsection