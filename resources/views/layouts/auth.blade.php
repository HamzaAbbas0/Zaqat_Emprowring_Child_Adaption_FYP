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

<body class="globalScreen mainSignupScreen">
    
    <style>
        .bg-image-vertical {
            position: relative;
            overflow: hidden;
            background-repeat: no-repeat;
            background-position: right center;
            background-size: auto 100%;
        }
        
        @media (min-width: 1025px) {
            .h-custom-2 {
                height: 100%;
            }
        }
    </style>

    @yield('content')

    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <script>
        // $('input[type=radio][name=user_type]').change(function() {
        //     const selectedValue = $(this).val()
        //     if (selectedValue == 'donor') {
        //         $(".user-type-toggle").addClass("d-none")
        //     }else{
        //         $(".user-type-toggle").removeClass("d-none")
        //     }
        // });
    </script>
</body>

</html>