@extends('layouts.layout')
@section('title', '::.Item')
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

        
        <form method="post" action="{{url('item/edit/'.$item['id'])}}">
         {{ csrf_field() }}
        <div class="row modal-row">


        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="category" id="edit-product-category" placeholder="Item" title="Item Category" readonly="readonly" value="{{$item['category']}}" />
                </div>
            </div>
            <span class="help-block small">Item Category</span>
        </div>

                 <input class="form-control" type="hidden" name="is_rgb" id="edit-product-is-rgb" value="{{$item['is_rgb']}}" />

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="item" id="edit-product-item" placeholder="Item" title="Item Name" value="{{$item['i_name']}}" />
                </div>
            </div>
            <span class="help-block small">Item Name</span>
        </div>
@if ($item['is_rgb'] == 1)
<div id="">
        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="qty_content" id="add-product-content" placeholder="Content" title="Content (Crates)" value="{{$item['qty_content']}}" />
                </div>
            </div>
            <span class="help-block small">Bottles with content (Crates) [{{ $item['rgb_qty_content'] }}]</span>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="qty_bottle" id="add-product-bottle" placeholder="Empty bottles" title="Empty Bottles (Crates)" value="{{$item['qty_bottle']}}" />
                </div>
            </div>
            <span class="help-block small">Empty Bottles (Crates) [{{ $item['rgb_qty_bottle'] }}]</span>
        </div>
</div>
@endif

@if ($item['is_rgb'] == 0)
        <div class="panel-body" id="nrgb">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="qty" id="add-product-qty" placeholder="Quantity" title="Quantity" value="{{$item['qty']}}" />
                </div>
            </div>
            <span class="help-block small">Quantity</span>
        </div>
@endif

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="cost_price" id="add-product-cost-price" placeholder="Cost Price" title="Cost Price" value="{{$item['cost_price']}}" />
                </div>
            </div>
            <span class="help-block small">Item Cost Price</span>
        </div>

        <div class="panel-body">
            <div class="">
                <div class=form-group>
                 <input class="form-control" type="text" name="price" id="add-product-price" placeholder="Selling Price" title="Selling Price" value="{{$item['price_unit']}}" />
                </div>
            </div>
            <span class="help-block small">Item Selling Price</span>
        </div>


        </div>

        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            <button type="submit" class="btn btn-danger btn-recharge" id="edit-product-save" >Save</button>
            <button type="reset" class="btn btn-modal-save pull-left" >Cancel</button>
        </div>

        </form>
        </div>
        </section>
@endsection