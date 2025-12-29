@extends('layouts.layout')
@section('title', '::.Purchases Report')
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
    <h4>Purchases Report</h4>
</div>
<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>Date</th>
        <th>Transaction Ref</th>
        <th>Supplier</th>
        <th>Item</th>
        <th>Exchange Type</th>
        <th>Quantity</th>
        <th>Rebate Quantity</th>
        <th>Unit Price</th>
        <th>Total Purchases</th>
        <th>Amount Paid</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
    <tr>
        <td>{{ date_create($item['created'])->format("j M Y, g:i a") }}</td>
        <td>{{ substr($item['transaction_ref'], -15) }}</td>
        <td>{{$item['s_name']}}</td>
        <td>{{$item['i_name']}}</td>
        <td>
        {{$item['exchange_type']}}
        </td>
        <td>{{$item['qty']}}</td>
        <td>{{$item['qty_rebate']}}</td>
        <td>{{$item['price_unit']}}
        <input type="hidden" id="id-add-item" value="{{$item['id']}}" />
        </td>
        <td>
        {{$item['price_total']}}
        </td>
        <td>{{$item['amount_paid']}}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="5" align="right">
        <strong>Total Quantity</strong>
        </td>
        <td>
        <strong>{{$total_quantity}}</strong>
        </td>

        <td colspan="3" align="right">
        <strong>Grand Total Purchases</strong>
        </td>
        <td>
        <strong>{{$total_purchases}}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="9" align="right">
        <strong>Grand Total Paid</strong>
        </td>
        <td>
        <strong>{{$total_paid}}</strong>
        </td>
    </tr>
    </tbody>
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