@extends('layouts.layout')
@section('title', '::.Bottle Log')
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
    <h4>Bottle Log</h4>
</div>
<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>Date</th>
        <th>Transaction Ref</th>
        <th>Name</th>
        <th>Error Type</th>
        <th>Quantity</th>
        <th>Amount Paid</th>
        <th>Comment</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
    <tr>
        <td>{{ date_create($item['created'])->format("j M Y, g:i a") }}</td>
        <td>{{$item['transaction_ref']}}</td>
        <td>{{$item['d_name']}}</td>
        <td>{{$item['error_type']}}</td>
        <td>
        {{$item['qty']}}
        </td>
        <td>{{$item['amount_paid']}}
        </td>
        <td>
        {{$item['comment']}}
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


        <td colspan="2">
        &nbsp;
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