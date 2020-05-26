@extends('layouts.guest')

@section('content')


<?php /*foreach ($errors->all() as $message) {
   echo $message;
}*/?>


<div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-4">
            <div class="card card-primary" id="reg_sec">
              <div class="card-header">
                <h3 class="card-title">Registre here</h3>
              </div>
            <div class="card-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
                        {!! csrf_field() !!}

                        @if ($errors->has('message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible">
                                {{ session('message') }}
                            </div>
                        @endif


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" value="{{ Request::old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Phone</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="phone">

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

 
                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Date of birth</label>

                            <div class="col-md-12">
                                <input type="date" class="form-control" name="dob">

                                @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">City</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="city">

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Amount</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="amount">

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Register
                                </button>

                                <a class="btn btn-link" href="{{ url('/login') }}">Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
