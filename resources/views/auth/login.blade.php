@extends('layout.app')
@section('login')
<div class="login-wrapper">
    <div class="form-login-wrapper">
        <form action="{{route('login.auth')}}" class="login-form" method="post">
            @csrf
            <h4 class="title">
                Welcome
            </h4>
            <input type="email" class="form-control mt-2" name="email" placeholder="Email" />
            <input type="password" class="form-control mt-2" style="direction:ltr;" name="password" placeholder="Password" />
            <input type="submit" class="btn btn-primary mt-3" style="width:100%" value="Login" />
        </form>
    </div>

</div>
@endsection