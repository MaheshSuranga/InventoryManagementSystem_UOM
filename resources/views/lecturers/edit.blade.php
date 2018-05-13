@extends('dashboard')
@section('page_heading')
    Edit Lecturer's Details
@endsection
@section('section')
<div class="well" style="margin:20px 20px">
    {!! Form::open(['action' => ['LecturersController@update', $lecturer->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('status','Mr.')}}
            {{Form::radio('status', 'Mr',true)}} 

            {{Form::label('status','Mrs.')}}
            {{Form::radio('status', 'Mrs.')}} 

            {{Form::label('status','Ms.')}}
            {{Form::radio('status', 'Ms')}} 
        </div>
        <div class="form-group">
            {{Form::label('designation','Designation')}}
            {{Form::text('designation',$lecturer->designation,['class' => 'form-control','placeholder' => 'Designation'])}}
        </div>
        <div class="form-group">
                {{Form::label('name','Name')}}
                {{Form::text('name',$lecturer->name,['class' => 'form-control','placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
                {{Form::label('email','E-mail')}}
                {{Form::text('email',$lecturer->email,['class' => 'form-control','placeholder' => 'Email'])}}
        </div>
        <div class="form-group">
                {{Form::label('contact','Contact No')}}
                {{Form::text('contact',$lecturer->contact,['class' => 'form-control','placeholder' => 'Contact No'])}}
        </div>
        <div class="form-group">
                {{Form::file('cover_image')}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
</div>
@endsection