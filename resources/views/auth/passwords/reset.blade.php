@extends('layouts.auth')

@section('content')
<section class="vh-100 forget-screen">
    <div class="container-fluid h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-4 col-lg-4 col-xl-3 order-2 order-lg-1 bg-white forget-password" style="border-radius:15px;">
                                <div class="text-center mb-4 mx-1 mx-md-4 mt-5">
                                    <a href="{{ route('/') }}"><img src="{{ asset('public/images/logo-md.png') }}" alt=""></a>
                                </div>
                                <div class="d-flex justify-content-center customHeading3 mb-3">
                                    <h3>Change Password</h3>
                                </div>
                                <form method="POST" action="{{ route('password.update') }}" name="resetForm" class="mx-1 mx-md-5 logForm">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div id="resetform">
                                        <div class="d-flex flex-row align-items-center mb-3">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="email">Email Address</label>
                                                <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" class="form-control @error('email') is-invalid @enderror" readonly />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-3">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="password">New Password</label>
                                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" autofocus />
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-3">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" />
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3 mb-lg-4 customCTA">
                                            <a href="javascript:document.resetForm.submit()" class="btn btn-block btn-xl gradient-custom-4 text-body success-alert btnSuccess">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
