@extends('dashboard')
@section('page_heading')
    Supervisors
@endsection
@section('section')
    @if(count($supervisors)>0)
        @foreach($supervisors as $supervisor)
            <div class="well">
                <div class="row">
                    <a href="/supervisors/{{$supervisor->id}}">
                        <div class="col-md-8 col-sm-8">
                            <h3>{!!$supervisor->status!!}. {!!$supervisor->name!!}</h3>                          
                            <small>email : {!!$supervisor->email!!}</small><br>
                            <small>contact No : {!!$supervisor->contact!!}</small>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @else
            <p>No supervisors found</p>
    @endif
@endsection