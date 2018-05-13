@extends('dashboard')
@section('page_heading')
    <a href="/supervisors" class="btn btn-default">Go Back</a>
    <div style="text-align:center">
        {{$supervisor->status}}. {{$supervisor->name}}
    </div>
    
@endsection
@section('section')
    <h3>Email Address : {{$supervisor->email}}</h3>
    <h3>Contact No : {{$supervisor->contact}}</h3>

    @can('update-supervisor')
        <a href="/supervisors/{{$supervisor->id}}/edit" class="btn btn-default">Edit</a>
    @endcan
    @can('delete-supervisor')
        {!!Form::open(['action' => ['SupervisorsController@destroy', $supervisor->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete',['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endcan
@endsection