<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap"
        rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/dist/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dist/main.css') }}" />

</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="sidebar-wrapper">
                    @include('template.sidebar')
                </div>
                <div class="content-wrapper">
                    @include('template.header')
                    <div class="inner-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src={{ asset('js/bootstrap.min.js') }}></script>
    <script type="module" src={{ asset('js/main.js') }}></script>
</body>

</html>
