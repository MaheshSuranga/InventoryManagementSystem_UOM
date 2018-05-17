@extends('dashboard')
@section('page_heading')
    <a href="/tos" class="btn btn-default">Go Back</a>
    <div style="text-align:center">
        {{$TO->status}}. {{$TO->name}}
    </div>
    
@endsection
@section('section')
    <h3>Email Address : {{$TO->email}}</h3>
    <h3>Contact No : {{$TO->contact}}</h3>

    @can('update-to')
        <a href="/tos/{{$TO->id}}/edit" class="btn btn-default">Edit</a>
    @endcan
    @can('delete-to')
        {!!Form::open(['action' => ['TOsController@destroy', $TO->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete',['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endcan
@endsection