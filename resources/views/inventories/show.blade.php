@extends('layouts.app')
@section('content')
    <a href="/inventories" class="btn btn-default">Go Back</a>
    <h1>{{$inventory->name}}</h1>
    <div class="well" style="margin:20px 250px">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{$inventory->id}}</td>
                </tr>
                <tr>
                    <th>Brand</th>
                    <td>{{$inventory->brand}}</td>
                </tr>
                <tr>
                    <th>Serial No</th>
                    <td>{{$inventory->serialno}}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{$inventory->price}}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{$inventory->description}}</td>
                </tr>
                <tr>
                    <th>Purchased Date</th>
                    <td>{{$inventory->purchaseddate}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @if(!auth::guest())
        @if(auth::user()->id == 1)
            <a href="/inventories/{{$inventory->id}}/edit" class="btn btn-default">Edit</a>

            {!!Form::open(['action' => ['InventoriesController@destroy', $inventory->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete',['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection