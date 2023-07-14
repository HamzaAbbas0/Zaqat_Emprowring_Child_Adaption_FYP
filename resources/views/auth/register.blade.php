@extends('layouts.auth')

@section('content')
<section class="vh-100">
    <div class="container-fluid signinScreen">
        <div class="row align-items-center">
            <div class="col-lg-5 px-0 d-none d-lg-block">
                <img src="{{ asset('/images/signup-bg.png') }}" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-3 text-black">
                <div class="d-flex px-3 ms-xl-4 pt-3 customCard shadow">

                    <form name="loginFields" class="loginFields" style="width: 25rem;" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="medium-logo text-center mb-3">
                            <a href="{{ route('/') }}"><img src="{{ asset('/images/logo-md.png') }}" alt=""></a>
                        </div>
                        <h3 class="pb-3 text-center">Sign Up</h3>

                        @error('inactive')
                            <div class="alert alert-success">{{ $message }}</div>
                        @enderror

                        <div class="row">
                            <div class="col-md-6 mb-1 pb-2">
                                <div class="form-outline">
                                    <label class="form-label" for="name" style="margin-left: 0px;">First Name</label>
                                    <input value="{{ old('name') }}" type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-1 pb-2">
                                <div class="form-outline">
                                    <label class="form-label" for="last_name" style="margin-left: 0px;">Last Name</label>
                                    <input value="{{ old('last_name') }}" type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-1 pb-2">
                                <div class="form-outline">
                                    <label class="form-label" for="email" style="margin-left: 0px;">Email</label>
                                    <input value="{{ old('email') }}" type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-1 pb-2">
                                <div class="form-outline">
                                    <label class="form-label" for="password" style="margin-left: 0px;">Password</label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-1 pb-2">
                                <div class="form-outline">
                                    <label class="form-label" for="password-confirm" style="margin-left: 0px;">Confirm Password</label>
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-1 pb-2">
                                <div class="form-outline">
                                    <label class="form-label" for="address" style="margin-left: 0px;">Address</label>
                                    <input type="text" value="{{ old('address') }}" id="address" name="address" class="form-control @error('address') is-invalid @enderror">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-1 pb-2">
                                <div class="form-outline">
                                    <label class="form-label" for="contact_no" style="margin-left: 0px;">Contact No</label>
                                    <input type="tel" value="{{ old('contact_no') }}" id="contact_no" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror">
                                    @error('contact_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- <div class="col-md-6 mb-1 pb-2 mb-3">
                                <div class="form-outline">
                                    <label class="form-label" for="user_type" style="margin-left: 0px;">Select User Type</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="user-type-donor" value="donor" checked />
                                    <label class="form-check-label" for="user-type-donor">Donor</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="user-type-applicant" value="applicant" />
                                    <label class="form-check-label" for="user-type-applicant">Applicant</label>
                                </div>
                            </div> -->
                            <!-- <div class="col-md-12 mb-1 pb-2 user-type-toggle">
                                <div class="form-outline">
                                    <label class="form-label" for="residence_verification" style="margin-left: 0px;">Residence Verification</label>
                                    <input type="file" id="residence_verification" name="residence_verification" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-1 pb-2 user-type-toggle">
                                <div class="form-outline">
                                    <label class="form-label" for="upload_picture" style="margin-left: 0px;">Upload Picture</label>
                                    <input type="file" id="upload_picture" name="upload_picture" class="form-control">
                                </div>
                            </div> -->
                        </div>

                        <div class="pt-1 mb-2 text-center">
                            <a href="javascript:document.loginFields.submit()" class="btn btn-lg btn-block customCTA" type="button">Sign Up</a>
                        </div>

                        <p class="text-center">Already Have An Account? <a href="{{ route('login') }}" class="link-info">Login</a></p>

                    </form>

                </div>

            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
</section>
@endsection