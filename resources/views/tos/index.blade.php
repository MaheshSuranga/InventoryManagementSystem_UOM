@extends('dashboard')
@section('page_heading')
    Technical Officers
@endsection
@section('section')
    @if(count($TOs)>0)
        @foreach($TOs as $TO)
            <div class="well">
                <div class="row">
                    <a href="/tos/{{$TO->id}}">
                        <div class="col-md-8 col-sm-8">
                            <h3>{!!$TO->status!!}. {!!$TO->name!!}</h3>                          
                            <small>email : {!!$TO->email!!}</small><br>
                            <small>contact No : {!!$TO->contact!!}</small>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @else
            <p>No supervisors found</p>
    @endif
@endsection