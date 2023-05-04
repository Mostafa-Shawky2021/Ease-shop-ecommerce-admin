@php
$notifications = \App\Models\Notification::all();

@endphp
<div class="notification-list-wrapper">
    <h6 class="title">الاشعارات</h6>
    <div class="notification-list">
        @forelse($notifications as $notification)
        <div class="notification-item">
            <div class="icon-cart">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="info">
                <a class="content"
                    href="{{route('orders.show',['order'=>$notification->id])}}">{{$notification->message}}</a>
            </div>
            <div class="icon-circle">
                <i class="fa fa-circle icon"></i>
            </div>
        </div>
        @empty
        <div class="notification-item">
            <div class="icon-cart">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="info">
                <p style="margin:0px">لا يوجد اشعارات</p>
            </div>
            <div class="icon-circle">
                <i class="fa fa-circle icon"></i>
            </div>
        </div>
        @endforelse
    </div>

</div>