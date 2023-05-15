@extends('layout.app')

@section('header-content')
<h5>البروفايل</h5>
@endsection


@section('content')

@if($errors->isNotEmpty())
@foreach($errors->all() as $error)
<div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif
<div class="col-6">
    <form action="{{route('profile.update')}}" class="mainform-app py-3 px-3" method="post">
        @csrf
        @method('PUT')
        <div class="">
            <label class="label-control" for="name">الاسم</label>
            <div class="mt-3">
                <input type="text" id="name" class="form-control" name="name" value="{{$admin->name}}">
            </div>
        </div>
        <div class="mt-3">
            <label class="label-control" for="email">البريد الالكتروني</label>
            <div class="mt-3">
                <input type="text" id="email" class="form-control" name="email" value="{{$admin->email}}">
            </div>
        </div>
        <div class="mt-3">
            <label class="label-control" for="current_password">كلمة السر الحالية</label>
            <div class="mt-3">
                <input type="password" class="form-control" id="current_password" name="current_password" />
            </div>
        </div>
        <div class="mt-3">
            <label class="label-control" for="password">كلمة السر الجديدة</label>
            <div class="mt-3">
                <input type="password" id="password" class="form-control" name="password" />
            </div>
        </div>
        <div class="mt-3">
            <label class="label-control" for="password_confirmation">تاكيد كلمة السر</label>
            <div class="mt-3">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" />
            </div>
        </div>
        <div class="mt-3">

            <button class="btn-add d-block ms-auto" id="saveBtn" style="border-radius:8px;font-size:0.8rem">
                تعديل البيانات
                <i class="icon fa fa-edit"></i>
            </button>
        </div>

    </form>


    @endsection