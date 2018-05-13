@extends('dashboard')
@section('page_heading')
    Lecturers
@endsection
@section('section')
    @if(count($lecturers)>0)
        @foreach($lecturers as $lecturer)
            <div class="well">
                <div class="row">
                    <a href="/lecturers/{{$lecturer->id}}">
                        <div class="col-md-8 col-sm-8">
                            @if($lecturer->designation != '')
                                <h3>{!!$lecturer->designation!!} {!!$lecturer->name!!}</h3>
                            @else
                                <h3>{!!$lecturer->status!!}</h3>
                            @endif
                            <small>email : {!!$lecturer->email!!}</small><br>
                            <small>contact No : {!!$lecturer->contact!!}</small>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @else
            <p>No lecturers found</p>
    @endif
@endsection