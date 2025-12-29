@extends('layouts.layout')
@section('title', '::.Debt Report')
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
    <h4>Debt Report</h4>
</div>
<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>Date</th>
        <th>Driver</th>
        <th>Receipt</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Amount Paid</th>
        <th>Debt</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
    <tr>
        <td>{{ date_create($item['created'])->format("j M Y, g:i a") }}</td>
        <td>{{$item['d_name']}}</td>
        <td>{{$item['receipt']}}</td>
        <td>{{$item['name']}}</td>
        <td>{{$item['total']}}
        <input type="hidden" id="id-add-item" value="{{$item['id']}}" />
        </td>
        <td>
        {{$item['amount_paid']}}
        </td>
        <td>
        {{$item['difference']}}
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="6" align="right">
        <strong>Total Debt</strong>
        </td>
        <td>
        <strong>{{$total_debt}}</strong>
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