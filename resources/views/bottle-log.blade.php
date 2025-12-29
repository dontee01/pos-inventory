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



<div class="row">

    <div class="col-md-9">

        <div class="row">

        <div class="col-md-12">
            <h1>Broken Bottles Log</h1>

            <form action="{{url('bottle/log')}}" method="post">
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
                        <input type="checkbox" id="is-rgb-staff" name="is_rgb_staff" value="1" />
                        <label for="is-rgb-staff"><span class="help-inline small">Were bottles broken by staff?</span></label>
                    </div>

                </div>

                <div class=" form-inline">

                    <div id="log-driver" class="form-group form-group-sm">
                        <select id="add-log-driver" class="input-sm " title="Select a driver" name="driver">
                            <option value="">Select a Driver</option>
                            <option value="Natural">Natural</option>
                            @foreach($drivers as $driver)
                                <option value="{{$driver->d_name}}">{{$driver->d_name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block small">Who broke the bottles ?</span>
                    </div>

                    <div id="log-staff" class="form-group form-group-sm">
                        <select id="add-log-staff" class="input-sm " title="Select a staff" name="staff" >
                            <option value="">Select a Staff</option>
                            @foreach($users as $staff)
                                <option value="{{$staff->name}}">{{$staff->name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block small">Who broke the bottles ?</span>
                    </div>

                    <div class="form-group form-group-sm">
                    <select class="input-sm " title="How did the bottles break?" name="type" required="required">
                        <option value="">Select Type</option>
                        <option value="Natural">Natural</option>
                        <option value="Damaged">Mistakenly Broken</option>
                        <option value="Expired">Expired Product</option>
                    </select>
                    <span class="help-block small">How did the bottles break ?</span>
                    </div>

                    <input class="input-sm" type="hidden" name="transaction_ref" id="add-quantity-is-rgb" readonly="readonly" value="{{Session::get('transaction_ref')}}" />

                </div>

                <div class="form-group form-group-sm">
                    <input type="checkbox" id="is_rgb_content" name="is_rgb_content" value="1" />
                <label for="is_rgb_content"><span class="help-inline small">Were bottles broken with content ?</span></label>
                </div>
                    


                <div class="form-group form-group-sm">
                    <input class="input-sm" type="text" name="quantity" id="add-quantity" title="Quantity" required="required" />
                    <span class="help-block small">Number of Bottles Broken</span>
                </div>

                <div class=" form-inline">
<!-- 
                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" v-model="price" name="price" id="add-quantity-price" title="Unit Price" required="required" />
                        <span class="help-block small">Unit Price Per Crate</span>
                    </div> -->

                    <div class="form-group form-group-sm">
                        <input class="input-sm" type="text" name="amount_paid" id="add-quantity-sub" title="Sub Total" required="required" />
                        <span class="help-block small">Amount Paid</span>
                    </div>
                </div>


                <div class="form-group form-group-sm">
                    <textarea name="comment" rows="3" cols="5" class="form-control"></textarea>
                    <span class="help-block small">Comment</span>
                </div>

                <div class="form-group form-group-sm">
                    <button class="btn btn-default btn-rounded btn-block" id="add-to-log" type="submit">Add</button>
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
                    Info
                </h1>
                <div class="small">
                    <p>
                        If bottles were not broken by anyone (i.e they broke naturally), instead of a driver's name, select natural<br><br>
                        If bottles were broken by staff, tick the check box and select the staff name<br>
                        Expired products logged as expired.
                    </p>
                    <p>
                        If bottles were broken with liquid, tick the check box
                    </p>
                    <p>
                        If some bottles were broken with liquid and some just empty bottles, you have to fill this form separately
                    </p>
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