@extends('layout.app')

@section('header-content')
<h5>الرسائل</h5>
@endsection


@section('content')
@include('partials.formmessage')
<div class="datatable-wrapper" id="messagesWrapper">
    <div class="d-flex justify-content-end">
        @include('partials.datatableheader')
    </div>
    <div class="contacts">
        @forelse($messages as $message)
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
                @php
                $routeParamter = ['message'=>$message->id];
                if(!$message->is_seen) {
                $routeParamter['is_seen'] = true;
                }
                @endphp
                <a class="btn btn-primary btn-sm" href="{{route('messages.show',$routeParamter )}}">عرض
                    الرسالة</a>
                <form method="post" action="{{route('messages.destroy',['message'=>$message->id])}}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">حذف الرسالة</button>
                </form>
            </li>
            <li class="mt-3 action-multiple">
                <input type="checkbox" class="action-checkbox" value="{{$message->id}}" />
            </li>
        </ul>
        @empty
        <div style="font-size:0.8rem; ">لا توجد رسائل</div>
        @endforelse
        {{$messages->links()}}
    </div>
</div>

@endsection

@push('scripts')
<script type="module">
    const messageElement = document.getElementById('message');
    const messageCharacterCount = messageElement.innerText.length;
    const limitCharacterCount = 200;
    const truncatedMessage =  messageElement.innerText.slice(0,limitCharacterCount);
      messageElement.innerText = messageCharacterCount > limitCharacterCount  
        ? messageElement.innerText +'...' 
        : messageElement.innerText;
</script>
@endpush