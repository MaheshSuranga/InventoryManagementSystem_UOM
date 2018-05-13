@extends('layouts.app')

<script type="text/javascript">
    function showfield(role){
      if(role==2){
        document.getElementById('desig').style.display="block";
      }
      else{
        document.getElementById('desig').style.display="none";
      } 
    }
</script>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="" class="col-md-4 control-label"></label>

                            <div class="col-md-6">
                                <label class="radio-inline"><input type="radio" name="optradio" value="Mr" checked>Mr.</label>
                                <label class="radio-inline"><input type="radio" name="optradio" value="Mrs">Mrs.</label>
                                <label class="radio-inline"><input type="radio" name="optradio" value="Ms">Ms.</label>

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="role" class="col-md-4 control-label">Role</label>

                            <div class="col-md-6">
                                <select id="role" type="text" class="form-control" name="role" value="{{ old('role') }}" onchange="showfield(this.options[this.selectedIndex].value)" required autofocus>
                                    @foreach($roles as $id=>$role)
                                        <option value="{{$id}}">{{$role}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('contact') ? ' has-error' : '' }}">
                                <label for="contact" class="col-md-4 control-label">Contact NO</label>
    
                                <div class="col-md-6">
                                    <input id="contact" type="text" class="form-control" name="contact" value="{{ old('contact') }}" required autofocus>
    
                                    @if ($errors->has('contact'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('contatct') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>

                        <div id="desig" style="display:none" class="form-group{{ $errors->has('designation') ? ' has-error' : '' }}">
                                <label for="designation" class="col-md-4 control-label">Designation</label>
    
                                <div class="col-md-6">
                                    <input id="designation" type="text" class="form-control" name="designation" value="{{ old('designation') }}" placeholder="Dr./ Eng./ Prof./ Associate Prof."required autofocus>
    
                                    @if ($errors->has('designation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('designation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
