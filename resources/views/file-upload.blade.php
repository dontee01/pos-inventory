@extends('layouts.layout')
@section('title', '::.Items')
@section('content')


    <section class="content bg-default">
            <div class="container-fluid">

        <!-- Display Validation Errors -->
        @include('common.errors')

        @if (Session::has('login_status'))
        <div class="alert alert-danger">
            <strong>{{Session::get('login_status')}}</strong>

            <br><br>

        </div>
        @endif
<div class="pull-right">
	<a href="{{url('item/add')}}" class="btn btn-default btn-rounded"><i class="fa fa-add"></i>Add Item</a>
</div>

    <form action="upload" method="post" enctype="multipart/form-data">
         {{ csrf_field() }}
        <input type="file" name="filefield">
        <input type="submit">
    </form>
		</div>
		</section>
@endsection