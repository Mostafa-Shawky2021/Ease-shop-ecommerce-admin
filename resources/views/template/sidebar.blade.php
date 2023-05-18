@php $urlSegment = Request::segment(2); @endphp
<aside class="sidebar" id="collapseSidebar">
    <ul class="list list-unstyled">

        <li class="item">
            <a href="{{route('dashboard')}}">
                <i class="fa fa-dashboard icon"></i>
                <span> لوحة التحكم</span>
            </a>

        </li>
        <li class="item">
            <a class="title">الادارة</a>
        </li>
        <li class="item">
            <a @class([ 'button-toggle' , 'submenu-visible'=> Request::is('admin/profile*'),
                ]) data-toggle="toggle-submenu">
                <i class="fa fa-user icon"></i>
                <span>المستخدمين</span>
                <i class="fa-solid fa-chevron-down chevron icon"></i>
            </a>
            <ul class="list-submenu toggle-submenu">

                <li class="item">
                    <a href="#">اضافة مستخدم جديد</a>
                </li>
                <li class="item">
                    <a href="{{route('profile.show')}}">الملف الشخصي</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#" class="title">المتجر</a>
        </li>
        <li class="item">
            <a @class([ 'button-toggle' , 'submenu-visible'=>
                Request::is('admin/categories*'),
                ])>
                <i class="fa-solid fa-tags icon"></i>
                <span>الاقسام</span>
                <i class="fa-solid fa-chevron-down chevron icon"></i>
            </a>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{ route('categories.index') }}">جميع الاقسام</a>
                </li>
                <li class="item">
                    <a href="{{ route('categories.create') }}">اضافة قسم</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a @class([ 'button-toggle' , 'submenu-visible'=>
                Request::is('admin/products*'),
                ])>
                <i class="fa-solid fa-shop icon"></i>
                <span>المنتجات</span>
                <i class="fa-solid fa-chevron-down chevron icon"></i>
            </a>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{ route('products.index') }}">جميع المنتجات</a>
                </li>
                <li class="item">
                    <a href="{{ route('products.create') }}">اضافة منتج</a>
                </li>
                <li class="item">
                    <a href="{{ route('products.index', ['status' => 'trashed']) }}">المنتجات
                        المحذوفة</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a @class([ 'button-toggle' , 'submenu-visible'=>
                Request::is('admin/color*') ||
                Request::is('admin/sizes*') ||
                Request::is('admin/brands*'),
                ])>
                <i class="fa-solid fa-box icon"></i>
                <span>خيارات المنتجات</span>
                <i class="fa-solid fa-chevron-down chevron icon"></i>
            </a>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{ route('colors.index') }}">الالون</a>
                </li>
                <li class="item">
                    <a href="{{ route('sizes.index') }}">المقاسات</a>
                </li>
                <li class="item">
                    <a href="{{ route('brands.index') }}">البراند</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#" class="title">الطلبات</a>
        </li>
        <li class="item">
            <a @class(['button-toggle', 'submenu-visible'=> Request::is('orders*')])>
                <i class="fa-solid fa-cart-shopping icon"></i>
                <span>الاوردرات</span>
                <i class="fa-solid fa-chevron-down chevron icon"></i>
            </a>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{ route('orders.index') }}">الاوردرات المعلقة</a>
                </li>
                <li class="item">
                    <a href="{{ route('orders.index', ['status' => 'completed']) }}">الاوردرات
                        المكتملة</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#" class="title">االتطبيقات</a>
        </li>
        <li class="item">
            <a href="{{route('messages.index')}}">
                <i class="fa-solid fa-message icon"></i>
                <span>الرسائل</span>
            </a>
        </li>
        <li class="item">
            <a href="#" class="title">العرض</a>
        </li>
        <li class="item">
            <a @class([ 'button-toggle' , 'submenu-visible'=>
                Request::is('admin/layout*'),
                ])>
                <i class="fa-solid fa-home icon"></i>
                <span>الصفحة الرئيسية</span>
                <i class="fa-solid fa-chevron-down chevron icon"></i>
            </a>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{ route('carousel.index') }}">السليدر</a>
                </li>
                <li class="item">
                    <a href="{{ route('footer.index') }}">الفوتر</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>