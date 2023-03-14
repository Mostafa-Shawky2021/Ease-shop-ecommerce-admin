<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>

    @include('template.header')

    <div class="d-flex">
        @include('template.sidebar')
        <div class="wrapper-content">
            <header class="header-content">
                <h4 class="title">@yield('header-content')
            </header>
            @yield('content')
        </div>
    </div>

    @stack('scripts')

</body>

</html>
