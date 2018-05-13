@extends('layouts.app')
@section('content')
    <h1>Edit Inventory</h1>
    <div class="well" style="margin:20px 20px">
    {!! Form::open(['action' => ['InventoriesController@update', $inventory->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name','Name')}}
            {{Form::text('name',$inventory->name,['class' => 'form-control','placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('brand','Brand Name')}}
            {{Form::text('brand',$inventory->brand,['class' => 'form-control','placeholder' => 'Brand Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('serial','Serial NO')}}
            {{Form::text('serial',$inventory->serialno,['class' => 'form-control','placeholder' => 'Serial NO'])}}
        </div>
        <div class="form-group">
            {{Form::label('price','Price')}}
            {{Form::text('price',$inventory->price,['class' => 'form-control','placeholder' => 'Price'])}}
        </div>
        <div class="form-group">
            {{Form::label('description','Description')}}
            {{Form::textarea('description',$inventory->description,['class' => 'form-control','placeholder' => 'Description'])}}
        </div>
        <div class="form-group">
            {{Form::label('purchase','Purchased Date')}}
            {{Form::date('purchase',\Carbon\Carbon::parse($inventory->purchaseddate),['class' => 'form-control','placeholder' => 'Purchased Date'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    </div>
@endsection