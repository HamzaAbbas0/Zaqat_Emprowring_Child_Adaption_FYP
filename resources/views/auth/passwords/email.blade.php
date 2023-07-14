@extends('layouts.auth')

@section('content')
<section class="vh-100 forget-screen">
    <div class="container-fluid h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-4 col-lg-4 col-xl-3 order-2 order-lg-1 bg-white forget-password">

                                <div class="text-center mb-4 mx-1 mx-md-4 mt-5">
                                    <a href="{{ route('/') }}"><img src="{{ asset('public/images/logo-md.png') }}" alt=""></a>
                                </div>
                                <div class="d-flex justify-content-center customHeading3 mb-3">
                                    <h3>Forgot Password</h3>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form name="forgotForm" class="mx-1 mx-md-5 logForm" method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="d-flex flex-row align-items-center mb-3">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="name">Email</label>
                                            <input type="email" id="name" name="email" class="form-control @error('email') is-invalid @enderror" />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center mb-3 mb-lg-4 customCTA">
                                        <a href="javascript:document.forgotForm.submit()" class="btn btn-block btn-xl gradient-custom-4 text-body success-alert">Send</a>
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
