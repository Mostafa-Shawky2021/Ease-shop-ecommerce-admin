@extends('layout.app')

@section('header-content')
<h5>عرض الرسالة</h5>
@endsection


@section('content')
<div class="contacts">
    <ul class="list-unstyled list-contacts">
        <li class="item">
            <i class="fa fa-user icon me-2 mt-1"></i>
            <div class="info d-flex">
                <span>الأسم</span>:
                <p>{{$message->username}}</p>
            </div>
        </li>
        <li class="item">
            <i class="fa fa-phone icon me-2 mt-1"></i>
            <div class="info">
                <p>رقم التلفون</span>:
                <p>{{$message->phone}}</p>
            </div>

        </li>
        <li class="item">
            <i class="fa fa-envelope icon me-2 mt-1"></i>
            <div class="info">
                <span>البريد الألكتروني</span>:
                <p>{{$message->email ?? 'لا يوجد'}}</p>
            </div>

        </li>
        <li class="item">
            <i class="fa fa-message icon me-2 mt-1"></i>
            <div class="info">
                <span>محتوي الرسالة</span>:
                <p id="message">{{$message->message}}</p>
            </div>
        </li>
        <li class="action mt-3 d-flex gap-2">
            <form method="post"
                action="{{route('messages.destroy',['message'=>$message->id])}}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('هل انت متاكد من الحذف؟!')"
                    class="btn btn-danger btn-sm">حذف الرسالة</button>
            </form>
        </li>
    </ul>
</div>
@endsection