@extends('dashboard')
@section('page_heading')
    Inventory Borrowing Histories
@endsection
@section('section')
@if(count($histories)>0)
    <div style="margin:20px 20px">
        @foreach($histories as $history)
            <div class="well">
                <h3>id : {{$history->intid}}</h3>
                <h3>Name : {{$history->intname}}</h3>
                <h3>Student : {{$history->name}}  Index : {{$history->index}}</h3>
                <h3>Issue date : {{$history->updated_at}}</h3>
            </div>
        @endforeach
    </div>
    {{$histories->links()}}
@else
    <p>There is no history available..</p>
@endif
@endsection