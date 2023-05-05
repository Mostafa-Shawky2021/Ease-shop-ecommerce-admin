<!DOCTYPE html>
<html lang="en">

<head>
    <title>لوحة التحكم</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


</head>

<body>

    @include('template.header')

    <div class="d-flex">
        @include('template.sidebar')

        <div class="main-wrapper">
            <header class="header-content">
                @yield('header-content')
            </header>

            <div class="content">
                @yield('content')
            </div>

        </div>
    </div>

    @stack('scripts')
    <script type='module'>
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
               search: "",
               paginate:{
                previous:'السابق',
                next:'التالي',
                searchPlaceholder:'البحث'
               }
            }
            });

    </script>
</body>

</html>
