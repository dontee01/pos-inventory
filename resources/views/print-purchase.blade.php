@extends('layouts.layout')
@section('title', '::.Print')
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



<div class="row non-printable">

    <div class="col-md-9">

        <div class="row">

        <div class="col-md-3">
            <!-- <div class="panel">
                <div class="panel-body">
                    <h1 class="m-t-md m-b-xs" style="margin-top: 30px">
                        <i class="pe pe-7s-global text-warning"> </i>
                        
                    </h1>
                    <div class="small">

                    </div>
                    <div class="m-t-sm">
                      
                    </div>
                </div>
            </div> -->
        </div>

        <div class="col-md-9">
            <!-- <h1>Inventory App</h1> -->

                
        <div class="col-md-12">
            <div class="panel-body">
        <!-- <p> -->
            <section style='position: relative;clear: both;height: 1px;border-top: 1px solid #cbcbcb;margin-bottom: 25px;margin-top: 10px;text-align: center;'>
                <h3 align='center' style='margin-top: -12px;background-color: #FFF;clear: both;width: 180px;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px; font-family: arial,sans-serif;'>
                    <span>Slip</span>
                </h3>
            </section>
        <!-- </p> -->

        <table width='550' border='0' cellspacing='0' cellpadding='0' style='color:#404041;'>
            <tbody>
                <tr>
                    <td width='15' style='color:#404041;font-size:12px;line-height:16px;border-bottom:solid 1px #e5e5e5'> S/N
                    </td>
                    <td colspan='' align='left' style='color:#404041;font-size:12px;line-height:16px;border-bottom:solid 1px #e5e5e5'>           
                        <strong>Product</strong>
                    </td>
                    <td width='85' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>
                        <strong>Supplier</strong>
                    </td>
                    <td width='85' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>
                        <strong>Quantity</strong>
                    </td>
                    <td width='100' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>
                        <strong>Sub Total (N)</strong>
                    </td>
                </tr>
                @foreach($cart_items as $key=>$cart)
                <tr>
                    <td width='15' style='color:#404041;font-size:12px;line-height:16px;border-bottom:solid 1px #e5e5e5'> {{$key + 1}}
                    </td>
                    <td colspan='' align='left' style='color:#404041;font-size:12px;line-height:16px;border-bottom:dashed 1px #e5e5e5'>
                        {{$cart['i_name']}}
                    </td>
                    <td width='85' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:dashed 1px #e5e5e5'>
                        {{$cart['s_name']}}
                    </td>
                    <td width='85' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:dashed 1px #e5e5e5'>
                        {{$cart['qty']}}
                    </td>
                    <td width='100' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>{{$cart['price_total']}}
                    </td>
                </tr>
                @endforeach


                <tr>
                    <td colspan="3" width='' style='color:#404041;text-align: right; font-size:12px;line-height:16px;border-bottom:solid 0px #e5e5e5'>
                    <strong>Grand Total</strong>
                    </td>
                    <td width='80' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:solid 4px #000'>
                        {{$price_total}}
                    </td>
                </tr>
                
            </tbody>
        </table>

        <div align="center" style='margin-top: 22px;color:#404041;text-align: center; font-size:12px;line-height:16px;border-bottom:solid 1px #e5e5e5'>
            <a class="btn btn-default" data-target="#printPurchaseModal" data-toggle="modal" >Print</a>
            <!-- <a class="btn btn-default" >PDF</a> -->
            <a class="btn btn-default" href="{{url('/purchase')}}" >Close</a>
        </div>

        </div>
        </div>

    
                            

        </div>
        
        
            
        </div>
        <!-- end row -->
    </div>
    <!-- end main col-8 -->


    <div class="col-md-3">
        <!-- <div class="panel">
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
        </div> -->
    </div>
</div>
<!-- end main row -->


        <div class="modal fade" id="printPurchaseModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                    <form method="post" id="compose-modal">
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Purchase Slip</h4>
                            </div>
                        </div>
                        <div class="modal-body printable">
                            <div>
                                <span>Receipt : {{$transaction_ref}}</span><br />
                                <span>Date : {{date('Y-m-d')}}</span>
                            </div>
                            
                                <table width='50%' border='0' cellspacing='0' cellpadding='0' style='color:#404041; font-size: 10px;'>
                                    <tbody>
                                        <tr>
                                            <td width='15' style='color:#404041;font-size:12px;line-height:16px;border-bottom:solid 1px #e5e5e5'> S/N
                                            </td>
                                            <td colspan='' align='left' style='color:#404041;font-size:12px;line-height:16px;border-bottom:solid 1px #e5e5e5'>           
                                                <strong>Product</strong>
                                            </td>
                                            <td width='85' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>
                                                <strong>Supplier</strong>
                                            </td>
                                            <td width='85' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>
                                                <strong>Quantity</strong>
                                            </td>
                                            <td width='100' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>
                                                <strong>Sub Total (N)</strong>
                                            </td>
                                        </tr>
                                        @foreach($cart_items as $key=>$cart)
                                        <tr>
                                            <td width='15' style='color:#404041;font-size:12px;line-height:16px;border-bottom:solid 1px #e5e5e5'> {{$key + 1}}
                                            </td>
                                            <td colspan='' align='left' style='color:#404041;font-size:12px;line-height:16px;border-bottom:dashed 1px #e5e5e5'>
                                                {{$cart['i_name']}}
                                            </td>
                                            <td width='85' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:dashed 1px #e5e5e5'>
                                                {{$cart['s_name']}}
                                            </td>
                                            <td width='85' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:dashed 1px #e5e5e5'>
                                                {{$cart['qty']}}
                                            </td>
                                            <td width='100' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>{{$cart['price_total']}}
                                            </td>
                                        </tr>
                                        @endforeach


                                        <tr>
                                            <td colspan="3" width='' style='color:#404041;text-align: right; font-size:12px;line-height:16px;border-bottom:solid 0px #e5e5e5'>
                                            <strong>Grand Total</strong>
                                            </td>
                                            <td width='80' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:solid 4px #000'>
                                                {{$price_total}}
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                        </div>
                        <div class="modal-footer" style="float:none;">

                            <a href="javascript:window.print()" class="btn btn-success">
                                                <i class="fa fa-print pr5"></i> Print</a>
                            <button type="button" class="btn btn-modal-save pull-left"
                                    data-dismiss="modal" >Close</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

    </div>
</section>

@endsection