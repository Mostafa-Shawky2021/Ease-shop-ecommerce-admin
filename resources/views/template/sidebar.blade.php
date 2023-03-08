<aside class="sidebar">
    <ul class="list list-unstyled">
        <li class="item">
            <a class="button-toggle" data-toggle="toggle-submenu">
                <i class="fa fa-user icon"></i>
                <span>المستخدمين</span>
                <i class="fa-solid fa-chevron-down icon"></i>
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
            <a class="button-toggle" data-toggle="toggle-submenu">
                <i class="fa-solid fa-tags icon"></i>
                <span>الاقسام</span>
                <i class="fa-solid fa-chevron-down icon"></i>
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
            <a class="button-toggle" data-toggle="toggle-submenu">
                <i class="fa-solid fa-shop icon"></i>
                <span>المنتجات</span>
                <i class="fa-solid fa-chevron-down icon"></i>
            </a>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{ route('products.index') }}">جميع المنتجات</a>
                </li>
                <li class="item">
                    <a href="{{ route('products.create') }}">اضافة منتج</a>
                </li>

            </ul>
        </li>

    </ul>
</aside>
