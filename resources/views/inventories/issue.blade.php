@extends('dashboard')
@section('page_heading')
    Issue Inventory
@endsection
@section('section')

    <div class="well" style="margin:20px 20px">
        <form class="form-horizontal" action="/inventory/issue" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="form-check" class="col-md-4 control-label">Select Inventories : </label>
                @foreach($inventories as $inventory)
                <div class="form-check col-md-6">
                    <input class="form-check-input" name="id[]" type="checkbox" value="{{$inventory->id}}" id="{{$inventory->id}}">
                    <label class="form-check-label" for="{{$inventory->id}}">{{$inventory->id}} {{$inventory->name}}</label>
                </div>
                @endforeach
                {{$inventories->links()}}
            </div>
            <div class="form-group">
                <label for="index" class="col-md-4 control-label">Student Index : </label>
                <div class="col-md-6">
                    <input type="text" id="index" name="index">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">Student Name : </label>
                <div class="col-md-6">
                    <input type="text" id="name" name="name">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">Lecturer/Supervisor : </label>
                <div class="col-md-6">
                    <select name="incharge" id="incharge">
                        <optgroup label="Lecturers">
                            @foreach($lecturers as $lecturer)
                            <option value="{{$lecturer->id}}">{{$lecturer->designation}} {{$lecturer->name}}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Supervisors">
                            @foreach($supervisors as $supervisor)
                            <option value="{{$supervisor->id}}">{{$supervisor->status}}. {{$supervisor->name}}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Send Email for Approval
                    </button>
                </div>
            </div>
            
        </form>
        
    </div>

@endsection
