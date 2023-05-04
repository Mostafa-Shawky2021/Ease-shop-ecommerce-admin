<header class="header d-flex">
 
    <div class="logo text-center">
        <a class="logo-link" href="#">Netfly</a>
    </div>

    <div class="header-content d-flex align-items-center">
        <div class="notification-wrapper" style="position:relative"
            id="collapseNotification">
            <button class="order-notification-btn button-toggle">
                <i class="fa fa-bell"></i>
                <span class="count">5</span>
            </button>
            @include('partials.notification')
        </div>
        <div class="user ms-auto">
            <img class="avatar" src="{{ asset('images/user.jpg') }}" alt="user-image"
                width="80" height="80" />
            <span class="hero-name">Mostafa</span>
        </div>
    </div>

    </div>

</header>