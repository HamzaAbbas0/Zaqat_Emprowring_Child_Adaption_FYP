@extends('layouts.auth')

@section('content')
<section class="vh-100">
    <div class="container-fluid signinScreen">
        <div class="row align-items-center">
            <div class="col-lg-5 px-0 d-none d-lg-block">
                <img src="{{ asset('images/signin-banner.png') }}" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-3 text-black">

                <div class="d-flex px-5 ms-xl-4 mt-5 pt-5 customCard shadow">

                    <form name="loginFields" class="loginFields" style="width: 23rem;" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="medium-logo text-center mb-3">
                            <a href="{{ route('/') }}"><img src="{{ asset('images/logo-md.png') }}" alt=""></a>
                        </div>
                        <h3 class="mb-3 pb-3 text-center">Sign in</h3>

                        @error('inactive')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-outline mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input value="{{ old('email') }}" type="email" id="email" name="email" class="form-control form-control-lg @error('password') is-invalid @enderror" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <p class="mb-2 pb-lg-2"><a href="{{ route('password.request') }}">Forgot Password?</a></p>

                        <div class="pt-1 mb-4 text-center">
                            <a href="javascript:document.loginFields.submit()" class="btn btn-lg btn-block customCTA" type="button">Sign In</a>
                        </div>

                        <p class="text-center">New User? <a href="{{ route('register') }}" class="link-info">Sign Up</a></p>

                    </form>

                </div>

            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
</section>
@endsection