@extends('layout.app')
@section('content')

<div class="user-add-wrapper">
    <header class="inner-content-header">
        <h4 class="title">New User</h4>
    </header>

    @if(!empty($errors->all()))
    <ul class='list-unstyled'>
        @foreach($errors->all() as $error) 
        <li class='alert alert-warning'>{{$error}}</li>
        @endforeach
    </ul>
    @endif
    <form class='user-add-form' method="post" action="{{route('users.store')}}">
        @csrf
        <div class='row align-items-center'>
            <div class='col-12 col-sm-2'>
                <label class='label-control'>Name</label>
            </div>
            <div class='col-12 col-sm-10'>
                <div class='d-flex name'>
                    <input value="{{old('fname')}}" class='form-control' type='text' placeholder="first name" name='fname'/>
                    <input value="{{old('lname')}}"class='form-control' type='text' placeholder="last name" name='lname'/> 
                </div>
            </div>
        </div>
        <div class="mt-4 row align-items-center">
            <div class='col-12 col-sm-2'>
                <label for="email" class='label-control'>Email</label>
            </div>
            <div class="col-12 col-sm-10">
                <input id="email" value="{{old('email')}}" name='email' class='form-control' placeholder="Enter your Email"/>
            </div>
        </div>
        <div class="mt-4 row align-items-center">
            <div class='col-12 col-sm-2'>
                <label for="password" class='label-control'>Password</label>
            </div>
            <div class="col-12 col-sm-10">
                <input value="{{old('password')}}" name='password' class='form-control' type='password' placeholder='Enter your Password'/>
            </div>
        </div>
        <div class="mt-4 row align-items-center">
            <div class='col-12 col-sm-2'>
                <label for="confirm-password" class='label-control'>Confirm password</label>
            </div>
            <div class='col-12 col-sm-10'>
                <input value="{{old('password_confirmation')}}" class='form-control' type='password' placeholder='Enter your Password' name='password_confirmation'/>
            </div>
        </div> 
        <div class="mt-4 row align-items-center">
            <div class='col-12 col-sm-2'>
                <label for="role" class='label-control'>Role</label>
            </div>
            <div class='col-12 col-sm-10'>
                <div class='d-inline-flex align-items-center'>
                    <input class='role' type='radio' name='role' id='regularuser' checked/>
                    <label for="regularuser" class='label-control'>Regular user</label>    
                </div>
                <div class='d-inline-flex align-items-center'>
                    <input value="{{old('fname')}}" class='input-checkbox' type='radio' name='role' id='admin'/>
                    <label for="admin" class='label-control'>Admin</label>    
                </div> 
            </div>
            <div class="mt-4 text-end">
                <button class="btn-add"><i class="icon fa fa-plus"></i>Add User</button>
            </div>
        </div> 
    </form>
</div>


@endsection