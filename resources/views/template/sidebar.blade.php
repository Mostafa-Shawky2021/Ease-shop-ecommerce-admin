<aside class="sidebar" id="collapseSidebar">
    <ul class="list list-unstyled">
        <li class="item">
            <a class="button-toggle" data-toggle="toggle-submenu">
                <i class="fa fa-user icon"></i>
                <span>المستخدمين</span>
                <i class="fa-solid fa-chevron-down chevron icon"></i>
            </a>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{ route('users.index') }}">جميع المستخدمين</a>
                </li>
                <li class="item">
                    <a href="{{ route('users.create') }}">اضافة مستخدم جديد</a>
                </li>
                <li class="item">
                    <a href="#">الملف الشخصي</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a href="#" class="title">المتجر</a>
        </li>
        <li class="item">
            <a @class([
                'button-toggle',
                'submenu-visible' => Request::segment(2) === 'categories',
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
            <a @class([
                'button-toggle',
                'submenu-visible' => Request::segment(2) === 'products',
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
                    <a href="{{ route('colors.index') }}">الالون</a>
                </li>
                <li class="item">
                    <a href="{{ route('sizes.index') }}">المقاسات</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <a @class([
                'button-toggle',
                'submenu-visible' => Request::segment(2) === 'orders',
            ])>
                <i class="fa-solid fa-cart-shopping icon"></i>
                <span>الاوردرات</span>
                <i class="fa-solid fa-chevron-down chevron icon"></i>
            </a>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{ route('orders.index') }}">جميع الاوردرات</a>
                </li>
                <li class="item">
                    <a href="{{ route('orders.create') }}">اضافة اوردر</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
