@extends('layouts.app')
@section('content')
    <a href="/inventories" class="btn btn-default">Go Back</a>
    <h1>{{$inventory->name}}</h1>
    <img class="col-md-4" src="/storage/cover_images/{{$inventory->cover_image}}" alt="">
    <div class="well col-md-8">
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
    <hr>
    @if(!auth::guest())
        @can('update-inventory')
            <a href="/inventories/{{$inventory->id}}/edit" class="btn btn-default">Edit</a>
        @endcan
        @can('delete-inventory')
            {!!Form::open(['action' => ['InventoriesController@destroy', $inventory->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete',['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endcan
    @endif
@endsection