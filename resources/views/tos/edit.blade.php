@extends('dashboard')
@section('page_heading')
    Edit Technical Officer's Details
@endsection
@section('section')
    {!! Form::open(['action' => ['TOsController@update', $TO->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('status','Mr.')}}
            {{Form::radio('status', 'Mr',true)}} 

            {{Form::label('status','Mrs.')}}
            {{Form::radio('status', 'Mrs.')}} 

            {{Form::label('status','Ms.')}}
            {{Form::radio('status', 'Ms')}} 
        </div>
        <div class="form-group">
                {{Form::label('name','Name')}}
                {{Form::text('name',$TO->name,['class' => 'form-control','placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
                {{Form::label('email','E-mail')}}
                {{Form::text('email',$TO->email,['class' => 'form-control','placeholder' => 'Email'])}}
        </div>
        <div class="form-group">
                {{Form::label('contact','Contact No')}}
                {{Form::text('contact',$TO->contact,['class' => 'form-control','placeholder' => 'Contact No'])}}
        </div>
        <div class="form-group">
                {{Form::file('cover_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection