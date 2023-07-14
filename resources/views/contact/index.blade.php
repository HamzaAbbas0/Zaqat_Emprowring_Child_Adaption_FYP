<?php
use App\Enums\UserTypes;

?>

@extends('layouts.app')

@section('content')

<div class="bottomBar shadow">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-4">
                <div class="dashboardTitle">
                    <h1>Contact</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Contact</li>
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
                <div class="col-lg-12 col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            
                            @if(session()->has('flash_error'))
                            <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                            @endif

                            @if(session()->has('flash_success'))
                            <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                            @endif

                            <div class="donationRequestForm">
                                <form method="POST" action="" name="loginFields">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="formLabel" for="name">Full Name</div>
                                            <div class="formField">
                                                <input type="text" value="{{ old('name') }}" id="name" name="name" class="form-control @error('name') is-invalid @enderror" />
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="formLabel" for="email">Email</div>
                                            <div class="formField">
                                                <input type="text" value="{{ old('email') }}" id="email" name="email" class="form-control @error('email') is-invalid @enderror" />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="formLabel" for="subject">Subject</div>
                                            <div class="formField">
                                                <input type="text" value="{{ old('subject') }}" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" />
                                                @error('subject')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="formLabel" for="message">Message</div>
                                        <div class="formField">
                                            <textarea type="text" id="message" name="message" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                            @error('message')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="formFieldBTN"><a href="javascript:document.loginFields.submit()">Submit</a></div>
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