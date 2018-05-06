@extends('layouts.app')
@section('content')
    <h1>Create New Inventory</h1>
    {!! Form::open(['action' => 'InventoriesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('name','Name')}}
            {{Form::text('name','',['class' => 'form-control','placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('brand','Brand Name')}}
            {{Form::text('brand','',['class' => 'form-control','placeholder' => 'Brand Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('serial','Serial NO')}}
            {{Form::text('serial','',['class' => 'form-control','placeholder' => 'Serial NO'])}}
        </div>
        <div class="form-group">
            {{Form::label('price','Price')}}
            {{Form::text('price','',['class' => 'form-control','placeholder' => 'Price'])}}
        </div>
        <div class="form-group">
            {{Form::label('description','Description')}}
            {{Form::textarea('description','',['class' => 'form-control','placeholder' => 'Description'])}}
        </div>
        <div class="form-group">
            {{Form::label('purchase','Purchased Date')}}
            {{Form::date('purchase',\Carbon\Carbon::now(),['class' => 'form-control','placeholder' => 'Purchased Date'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection