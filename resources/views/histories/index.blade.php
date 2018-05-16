@extends('dashboard')
@section('page_heading')
    Inventory Borrowing Histories
@endsection
@section('section')
@if(count($histories)>0)
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Index</th>
                <th>Student Name</th>
                <th>Issue Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
                <tr>
                    <td>{{$history->intid}}</td>
                    <td>{{$history->intname}}</td>
                    <td>{{$history->index}}</td>
                    <td>{{$history->name}}</td>
                    <td>{{$history->updated_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{$histories->links()}}
@else
    <p>There is no history available..</p>
@endif
@endsection