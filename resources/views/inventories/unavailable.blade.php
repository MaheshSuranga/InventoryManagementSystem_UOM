@extends('dashboard')
@section('page_heading')
    Currently Unavailable Inventories List
@endsection
@section('section')
    @if(count($inventories)>0)
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Issued Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventories as $inventory)
                    <tr>
                        <td>{{$inventory->id}}</td>
                        <td>{{$inventory->name}}</td>
                        <td>{{$inventory->updated_at}}</td>
                        <td>{!!Form::open(['action' => ['InventoriesController@return', $inventory->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                {{Form::submit('Return to lab',['class' => 'btn btn-success'])}}
                            {!!Form::close()!!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>All inventories are available in the lab</p>
    @endif
@endsection