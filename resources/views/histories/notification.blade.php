@extends('dashboard')
@section('page_heading')
    Inventory Borrowing Request List
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
                <th>Requested Date</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
                <tr>
                    <td>{{$history->intid}}</td>
                    <td>{{$history->intname}}</td>
                    <td>{{$history->index}}</td>
                    <td>{{$history->name}}</td>
                    <td>{{$history->created_at}}</td>
                    <td>{!!Form::open(['action' => ['HistoriesController@destroy', $history->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Reject',['class' => 'btn btn-danger'])}}
                        {!!Form::close()!!}
                    </td>
                    <td><a href="/histories/{{$history->id}}" class="btn btn-success pull-right">Approve</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{$histories->links()}}
@else
    <p>There is no pending request available..</p>
@endif
@endsection