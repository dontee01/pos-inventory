@extends('layouts.layout')
@section('title', '::.Stock Report')
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
    <h4>Stock Report</h4>
</div>
<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>Item</th>
        <th>Bottles with Content (Crates)</th>
        <th>Empty Bottles (Crates)</th>
        <th>Quantity (For Non RGB)</th>
        <th>Total (N)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key=>$item)
    <tr>
        <td>{{$item['i_name']}}</td>
        <td>{{$item['qty_content']}}</td>
        <td>{{$item['qty_bottle']}}</td>
        <td>{{$item['qty']}}</td>
        <td>{{$item['amount']}}
        <input type="hidden" id="id-add-item" value="{{$item['id']}}" />
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="4" align="right">
        <strong>Grand Total</strong>
        </td>
        <td>
        <strong>{{$amount_total}}</strong>
        </td>
    </tr>
    </tbody>
</table>
<div align="center">
    <!-- <h4>Empty Crates</h4> -->
    <h4>Total Bottles</h4>
</div>

<table class="table table-hover table-striped" id="table-custom">
    <thead>
    <tr>
        <th>Category</th>
        <th>Quantity</th>
        <th>Total (N)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $key=>$category)
    <tr>
        <td>{{$category['cat_name']}}</td>
        <td>{{$category['total_rgb']}}</td>
        <td>{{$category['amount_total']}}
        </td>
    </tr>
    @endforeach
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