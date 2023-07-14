<?php
use App\Enums\UserTypes;

?>

@extends('layouts.app')

@section('content')

<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between align-items-center customCenter">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>Add User</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Add User</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contentPageWhiteBG mb-5">
    <div class="row justify-content-center mx-3">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h4>Add User</h4>
                            <div class="donationRequestForm newRequestForm">
                                <form name="fieldsForm" action="" method="POST">
                                    @csrf

                                    @if(session()->has('flash_error'))
                                        <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                                    @endif

                                    @if(session()->has('flash_success'))
                                        <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                                    @endif
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="formLabel" id="role">Role</div>
                                            <div class="formField">
                                                <select name="role" id="role" class="w-100 @error('role') is-invalid @enderror">
                                                    <option value="">Select Role</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel" id="name">Name</div>
                                            <div class="formField">
                                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" />
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel" id="email">Email</div>
                                            <div class="formField">
                                                <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel" id="password">Password</div>
                                            <div class="formField">
                                                <input type="text" type="password" name="password" value="" class="form-control @error('password') is-invalid @enderror" />
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formLabel" id="password-confirm">Confirm Password</div>
                                            <div class="formField">
                                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="formFieldBTN d-flex flex-row mb-3">
                                            <a href="javascript:document.fieldsForm.submit()" style="padding: 8px 15px;">Add User</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                @include('shared.graph-column')
                @endif

            </div>
        </div>
    </div>
</div>

@endsection