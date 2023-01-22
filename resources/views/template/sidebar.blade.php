<aside class="sidebar">
    <h3 class="brand">Logo Here</h3>
    <ul class="list list-unstyled">
        <li class="item">
            <button class="button-toggle" data-toggle="toggle-submenu">
                <i class="fa fa-user"></i>
                <span>Users</span> 
                <i class="icon fa fa-chevron-right"></i>
            </button>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{route('users.index')}}">All users</a>
                </li>
                <li class="item">
                    <a href="{{route('users.create')}}">Add user</a>
                </li>
                <li class="item">
                    <a href="#">Profile</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <button class="button-toggle" data-toggle="toggle-submenu">
                <i class="fa fa-user"></i>
                <span>Categories</span> 
                <i class="icon fa fa-chevron-right"></i>
            </button>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{route('categories.index')}}">All categories</a>
                </li>
                <li class="item">
                    <a href="{{route('categories.create')}}">Add category</a>
                </li>
                <li class="item">
                    <a href="#">Profile</a>
                </li>
            </ul>
        </li>
        <li class="item">
            <button class="button-toggle" data-toggle="toggle-submenu">
                <i class="fa fa-user"></i>
                <span>Products</span> 
                <i class="icon fa fa-chevron-right"></i>
            </button>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{route('products.index')}}">All products</a>
                </li>
                <li class="item">
                    <a href="{{route('products.create')}}">Add product</a>
                </li>
                <li class="item">
                    <a href="#">Profile</a>
                </li>
            </ul>
        </li>
        <div className="seperator">Layout</div>
        <li class="item">
            <button class="button-toggle" data-toggle="toggle-submenu">
                <i class="fa fa-user"></i>
                <span>Offer Section</span> 
                <i class="icon fa fa-chevron-right"></i>
            </button>
            <ul class="list-submenu toggle-submenu">
                <li class="item">
                    <a href="{{route('products.index')}}">All Offer</a>
                </li>
                <li class="item">
                    <a href="{{route('products.create')}}">Add product</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
