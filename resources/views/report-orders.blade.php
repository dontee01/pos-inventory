@extends('layouts.layout')
@section('title', '::.Sales Orders')
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
    <h4>Sales Orders</h4>
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
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
    <tr>
        <td>{{ date_create($item['created'])->format("j M Y, g:i a") }}</td>
        <td>{{$item['transaction_ref']}}</td>
        <td>{{$item['d_name']}}</td>
        <td>{{$item['i_name']}}</td>
        <td>
        {{$item['qty']}}
        </td>
        <td>{{$item['price_unit']}}
        <input type="hidden" id="id-add-item" value="{{$item['id']}}" />
        </td>
        <td>
        {{$item['price_total']}}
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="4" align="right">
        <strong>Total Quantity</strong>
        </td>
        <td>
        <strong>{{$total_quantity}}</strong>
        </td>

        <td colspan="1" align="right">
        <strong>Grand Total</strong>
        </td>
        <td>
        <strong>{{$price_total}}</strong>
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