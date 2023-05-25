@php
$activeNotificationsCount = \App\Models\Notification::where('is_seen', 0)->count();
$notifications = \App\Models\Notification::orderBy('is_seen', 'asc')
->orderBy('id', 'desc')
->get();

@endphp
<header class="header d-flex">
    <div class="logo text-center">
        <a class="logo-link text-center" href="#">Ease Shop</a>
    </div>
    <div class="header-content d-flex align-items-center">
        <button id="openSidebar" class="open-sidebar-btn">
            <i class="fa fa-bars"></i>
        </button>
        <div class="notification-wrapper" style="position:relative" id="collapseNotification">
            <button class="order-notification-btn button-toggle">
                <i class="fa fa-bell"></i>
                @if($activeNotificationsCount > 0)
                <span class="count">{{$activeNotificationsCount}}</span>
                @endif
            </button>
            @include('partials.notification',compact('notifications'))
        </div>
        <div class="user ms-auto">
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center justify-content-between gap-2"
                    type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="avatar" src="{{ asset('images/user.jpg') }}" alt="user-image" width="80" height="80" />
                    <span class="hero-name">{{auth()->user()->name}}</span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a class="dropdown-item" href="{{route('profile.show')}}">
                            <i class="fa fa-user"></i>
                            الصفحة الشخصية
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('logout')}}">
                            <i class="fa fa-sign-out"></i>
                            تسجيل الخروج
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    </div>

</header>