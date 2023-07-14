<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<style>
    @media (min-width: 1400px) {

        .container,
        .container-lg,
        .container-md,
        .container-sm,
        .container-xl,
        .container-xxl {
            max-width: 1800px;
        }
    }
</style>

<body>

    <section class="vh-100 bg-image voklogik-main welcome-screen" style="background-image: url('{{ asset('images/welcome-bg.png') }}'); ">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-5">
                        <div class="card">
                            <div class="card-body p-5 text-center">
                                <p class="welcome-head">"When You Become A Lion, You Become Part Of A Global Network Of Volunteers Working Together To Make A Difference."</p>
                                <h2 class="text-center mt-5 mb-4 heading-white customHeading">Hello! Welcome</h2>
                                <a href="welcome.html"><img src="{{ asset('images/logo.png') }}" alt="" class="mb-5"></a>
                                <form>
                                    <div class="d-flex justify-content-center customCTA mb-5">
                                        <p>Please Register Yourself</p>
                                        <a href="{{ route('register') }}" class="btn btn-block btn-lg gradient-custom-4 text-body">Registration</a>
                                    </div>

                                    <div class="d-flex justify-content-center customCTA">
                                        <p>Already User?</p>
                                        <a href="{{ route('login') }}" class="btn btn-block btn-lg gradient-custom-4 text-body">Log in</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <ul class="welcomList">
                            <li><a target="_blank" href="{{ route('terms') }}">Terms</a></li>
                            <li class="pipeLine">|</li>
                            <li><a target="_blank" href="{{ route('privacy') }}">Privacy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
</body>

</html>