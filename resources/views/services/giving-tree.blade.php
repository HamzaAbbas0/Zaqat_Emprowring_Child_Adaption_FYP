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
                    <h1>Giving Tree Sign Up</h1>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('history.index') }}">Requests</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li><a href="{{ route('requests.create') }}">Add New Request</a></li>
                        <li><i class="fas fa-chevron-right"></i></li>
                        <li>Giving Tree Sign Up</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="contentPageWhiteBG mb-5">
    <div class="row justify-content-center mx-3">
        <div class="col-lg-12 col-md-12">
            <div class="card shadow givingTreePage mb-4">
                <div class="card-header" id="cardHeader">
                    <h2 id="givingTreePageTitle">Giving Tree Sign Up</h2>
                    <p id="givingTreePageText">We are only able to accept application for families with students in the North Mason county school district.</p>
                </div>
                <div class="card-body">
                    <div class="donationRequestForm newRequestForm">
                        <form name="givingTreeForm" action="" method="POST">
                            @csrf

                            @if(session()->has('flash_error'))
                                <div class="alert alert-danger">{{ session()->get('flash_error') }}</div>
                            @endif
                            @if(session()->has('flash_success'))
                                <div class="alert alert-success">{{ session()->get('flash_success') }}</div>
                            @endif

                            <div class="row">

                                @if(in_array(auth()->user()->role_id, [UserTypes::Admin, UserTypes::Moderator]))
                                <div class="col-lg-12">
                                    <div class="formLabel">User</div>
                                    <div class="formField">
                                        <select name="user" id="user" class="w-100 @error('user') is-invalid @enderror">
                                            <option value="">Select User</option>
                                            @foreach($applicants as $applicant)
                                                <option value="{{ $applicant->id }}" {{ old('user') == $applicant->id ? 'selected' : '' }} >{{ ucfirst($applicant->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('user')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif

                                <div class="col-lg-4">
                                    <div class="formLabel">Name</div>
                                    <div class="formField">
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" />
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="formLabel">Address</div>
                                    <div class="formField">
                                        <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control @error('address') is-invalid @enderror" />
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="formLabel">City</div>
                                    <div class="formField customSelectBox">
                                        <select name="city_id" id="select-city" class="form-select @error('city_id') is-invalid @enderror">
                                            <option value="">Select City</option>
                                            <option value="30776">Belfair</option>
                                            <option value="30750">Allyn</option>
                                            <option value="30958">Grapeview</option>
                                            <!-- <option value="30796">Bremerton</option> -->
                                            <option value="31280">Tahuya</option>
                                        </select>
                                        @error('city_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="formLabel">Zip</div>
                                    <div class="formField">
                                        <input type="text" name="zip" value="{{ old('zip') }}" class="form-control @error('zip') is-invalid @enderror" />
                                        @error('zip')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="formLabel">Phone Number</div>
                                    <div class="formField">
                                        <input type="text" name="phone_no" value="{{ old('phone_no', $user->contact_no) }}" class="form-control @error('phone_no') is-invalid @enderror" />
                                        @error('phone_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="formLabel">People in Household</div>
                                    <div class="formField">
                                        <input type="number" name="people_in_household" value="{{ old('people_in_household') }}" class="form-control @error('people_in_household') is-invalid @enderror" />
                                        @error('people_in_household')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="formLabel">Email</div>
                                    <div class="formField">
                                        <input type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
                            <div class="formFieldBTN">
                                <a href="javascript:document.givingTreeForm.submit()">Next</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('footer-scripts')
<script>
    
</script>

@endsection