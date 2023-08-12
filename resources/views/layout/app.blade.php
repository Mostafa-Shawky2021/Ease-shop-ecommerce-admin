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

    @yield('login')
    @auth
    @include('template.header')

    <div class="d-flex">

        @include('template.sidebar')

        <div class="main-wrapper">
            <div class="container-fluid px-md-4">
                <header class="header-content">
                    @yield('header-content')
                </header>
                @yield('content')

            </div>
        </div>
        @endauth

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
            //sidebar button icon  
            const sideBarBtn = document.getElementById("openSidebar");
            const sideBar = document.getElementById("collapseSidebar");   
            
            function toggleSidebar(){
                sideBar.classList.toggle('open-mobile')
                if(sideBar.classList.contains('open-mobile')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }     
            }

            // close sidebar in small screens
            function toggleSmallScreen(){

                if(window.innerWidth <= 992) {
                    if(event.key === "Escape") {
                        if(sideBar.classList.contains('open-mobile'))  {
                            sideBar.classList.remove('open-mobile')
                            document.body.style.overflow = 'auto'; 
                        }   
                    }
                }
            }

            sideBarBtn.addEventListener("click",toggleSidebar)
            window.addEventListener("keydown",toggleSmallScreen)
        

        </script>
</body>

</html>