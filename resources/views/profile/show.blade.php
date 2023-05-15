@extends('layout.app')

@section('header-content')
<h5>البروفايل</h5>
@endsection


@section('content')

<div class="profile-container">
    <ul class="list-unstyled profile-list">
        <li class="item">
            <span>الاسم:</span>
            <span>{{$admin->name}}</span>
        </li>
        <li class="item">
            <span>
                البريد الالكتروني:
            </span>
            <span>
                {{$admin->email}}
            </span>
        </li>
    </ul>
    <a class="btn btn-primary btn-sm" href="{{route('profile.edit')}}">تعديل</a>
</div>


@endsection