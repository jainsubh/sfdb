@extends('admin::layouts.master')
@section('before-css')
@endsection
@section('main-content')
   <div class="breadcrumb">
        <h1>Add User</h1>
        <ul>
            <li><a href="{{ route('users.index') }}">Users</a></li>
            <li>Add</li>
            
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    @include('admin::layouts.errors')
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">User Information</div>
                    <form method="post" action="{{ route('users.index') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter your full name" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Form Group New Layout -->

                            <div class="col-md-6 form-group mb-3">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                           
                            <div class="col-md-6 form-group mb-3">
                                <label for="phone_no">Phone No</label>
                                <input type="tel" class="form-control @error('phone_no') is-invalid @enderror" id="phone_no" name="phone_no" placeholder="Enter your phone number" required>
                                @error('phone_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="user_timezone">User TimeZone</label>
                                {{ Form::select('timezone', $timezones, 'Asia/Dubai', ['class'=>'form-control']) }}
                            </div>
                            
                            <div class="col-md-6 form-group mb-3">
                                <label for="user_type">User Type</label>
                                {!! Form::select('roles', $roles, null, ['class' => 'form-control']) !!}
                                @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <button type="submit" class="btn btn-primary ladda-button example-button m-1" name="submit" data-style="expand-right">Submit</button>
                                <button type="button" class="btn btn-default m-1" onclick="window.location='{{ route('users.index') }}'">Cancel</button>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
@endsection

@section('bottom-js')
@endsection
