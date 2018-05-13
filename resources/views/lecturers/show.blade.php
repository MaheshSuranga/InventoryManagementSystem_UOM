@extends('dashboard')
@section('page_heading')
    <a href="/lecturers" class="btn btn-default">Go Back</a>
    <div style="text-align:center">
        @if($lecturer->designation != '')
            {{$lecturer->designation}} {{$lecturer->name}}
        @else
            {{$lecturer->status}} {{$lecturer->name}}
        @endif
    </div>
    
@endsection
@section('section')
    <h3>Email Address : {{$lecturer->email}}</h3>
    <h3>Contact No : {{$lecturer->contact}}</h3>

    @can('update-lecturer')
        <a href="/lecturers/{{$lecturer->id}}/edit" class="btn btn-default">Edit</a>
    @endcan
    @can('delete-lecturer')
        {!!Form::open(['action' => ['LecturersController@destroy', $lecturer->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete',['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endcan
@endsection