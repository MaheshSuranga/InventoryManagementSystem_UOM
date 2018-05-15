@extends('dashboard')
@section('page_heading')
    Inventory Borrowing Request List
@endsection
@section('section')
@if(count($histories)>0)
    <div style="margin:20px 20px">
        @foreach($histories as $history)
            <div class="well">
                <h3>id : {{$history->intid}}</h3>
                <h3>Name : {{$history->intname}}</h3>
                <h3>Student : {{$history->name}}  Index : {{$history->index}}</h3>
                <h3>Requested date : {{$history->created_at}}</h3>

                <a href="/histories/{{$history->id}}" class="btn btn-success pull-right">Approve</a>
                {!!Form::open(['action' => ['HistoriesController@destroy', $history->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Reject',['class' => 'btn btn-danger'])}}
                {!!Form::close()!!}
            </div>
        @endforeach
    </div>
    {{$histories->links()}}
@else
    <p>There is no pending request available..</p>
@endif
@endsection