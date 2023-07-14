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
                    <h1>Settings</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Settings</li>
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
                <div class="col-lg-8 col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form name="settingsForm"  method="POST" action="{{ route('settings.save') }}" enctype="multipart/form-data">
                                @csrf

                                @if(session()->has('flash_error'))
                                    <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                                @endif

                                @if(session()->has('flash_success'))
                                    <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="profilePic">
                                            <div class="canditate-des">
                                                <a href="javascript:void(0);" class="profile-image-label">
                                                    <img id="profile-image" alt="{{ auth()->user()->name }}" src="{{ getProfileImage(auth()->user()) }}" />
                                                </a>
                                                <div class="upload-link text-center" title="" data-bs-toggle="tooltip" data-placement="right" data-bs-original-title="update">
                                                    <input 
                                                        type="file" 
                                                        class="update-flie"
                                                        name="upload_picture"
                                                        onchange="document.getElementById('profile-image').src = window.URL.createObjectURL(this.files[0])" 
                                                    />
                                                    <i class="fa fa-camera"></i>
                                                </div>
                                            </div>
                                            <div class="candidate-title profile-image-label">
                                                <div class="">
                                                    <p class="m-b0"><a href="javascript:void(0);">Upload Picture</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="donationRequestForm">
                                            <form action="">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="formLabel">Full Name</div>
                                                        <div class="formField">
                                                            <input type="text" value="{{ auth()->user()->name }}" name="name" class="form-control @error('name') is-invalid @enderror" disabled />
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="formLabel">Email</div>
                                                        <div class="formField">
                                                            <input type="email" value="{{ auth()->user()->email }}" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="formLabel">Password</div>
                                                        <div class="formField">
                                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" disabled />
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="formLabel">Confirm Password</div>
                                                        <div class="formField">
                                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="formLabel">Address</div>
                                                        <div class="formField">
                                                            <input type="text" name="address" value="{{ auth()->user()->address }}" class="form-control @error('address') is-invalid @enderror" disabled />
                                                            @error('address')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    
                                                    @if(auth()->user()->role_id == UserTypes::Applicant)
                                                    <div class="col-md-12">
                                                        <label class="form-label" for="residence_verification" style="margin-left: 0px;">Verification of Residence</label>
                                                        <div class="formField">
                                                            <input type="file" name="residence_verification" id="residence_verification" class="form-control">
                                                        </div>
                                                    </div>
                                                    @endif
                                                    
                                                    <div class="col-md-12">
                                                        <div class="formLabel">Contact No</div>
                                                        <div class="formField">
                                                            <input type="text" name="contact_no" value="{{ auth()->user()->contact_no }}" class="form-control @error('contact_no') is-invalid @enderror" disabled />
                                                            @error('contact_no')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="formFieldBTN">
                                                    <a href="#" id="editBtn">Edit</a>
                                                    <a href="#" id="saveBtn">Save</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </form>
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


@section('footer-scripts')
<script>
    $('#editBtn').on("click", function(){
        if($('input[name="name"]').attr('disabled') == 'disabled'){
            $('input[name="name"],input[name="password"],input[name="password_confirmation"],input[name="address"],input[name="contact_no"]').attr('disabled', false);
            
            $('#saveBtn').attr('href', 'javascript:document.settingsForm.submit()');
            $('#editBtn').html('Cancel');
        }else{
            $('#editBtn').html('Edit');
            $('input[name="name"],input[name="password"],input[name="password_confirmation"],input[name="address"],input[name="contact_no"]').attr('disabled', true);
            $('#saveBtn').attr('href', '#');
        }
    });
    
    $(document).on("click", ".profile-image-label", function() {
        $(".update-flie").click();
    });
</script>
@endsection