@extends('admin::layouts.master')
@section('before-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/pickadate/classic.date.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
@endsection

@section('main-content')
   <div class="breadcrumb">
        <h1>Edit User</h1>
        <ul>
            <li><a href="{{ route('users.index') }}">Users</a></li>
            <li>Edit</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    @include('admin::layouts.errors')
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">User Information</div>
                    <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('Put')
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" placeholder="Enter your full name" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}" placeholder="Enter email" required disabled>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                           
                            <div class="col-md-6 form-group mb-3">
                                <label for="phone_no">Phone No</label>
                                <input type="tel" class="form-control @error('phone_no') is-invalid @enderror" value="{{ $user->phone_no }}" name="phone_no" placeholder="Enter your phone number" required>
                                @error('phone_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="user_timezone">User TimeZone</label>
                                {{ Form::select('timezone', $timezones, $user->timezone, ['class'=>'form-control']) }}
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="user_type">User Type</label>
                                {!! Form::select('roles', $roles, $currentUserRole, ['class' => 'form-control']) !!}
                                @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="col-md-12">
                                <button type="submit" name="submit"  class="btn btn-primary ladda-button example-button m-1" data-style="expand-right">Submit</button>
                                <button type="button" class="btn btn-default m-1"  onclick="window.location='{{ route('users.index') }}'">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('page-js')
<script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
<script src="{{asset('assets/js/ladda.script.js')}}"></script>
@endsection

@section('bottom-js')
@endsection
