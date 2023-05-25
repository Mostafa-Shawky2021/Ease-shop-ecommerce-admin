<div class="notification-list-wrapper" id="collapseList">
    <h6 class="title">
        <span>
            الاشعارات
            <i class="fa fa-bell" style="color:#2a3042;margin:0px 5px"></i>
        </span>
        <span>
            @if($notifications->isNotEmpty())
            <a href="{{route('notifications.index')}}" class="view-more">...عرض المزيد</a>
            @endif
        </span>
    </h6>
    <div class="notification-list">
        @forelse($notifications as $notification)
        <div class="notification-item">
            <div class="icon-cart">
                @if($notification->notifiable instanceof \App\Models\Order )
                <i class="fa fa-shopping-cart"></i>
                @else
                <i class="fa fa-message"></i>
                @endif
            </div>
            <div class="info">
                @php
                $routeName = "";
                $routeParams = [];
                if($notification->notifiable instanceof \App\Models\Order ) {

                $routeName = 'orders.show';
                $routeParams = ['order'=>$notification->notifiable->id];
                }
                elseif($notification->notifiable instanceof \App\Models\Message) {
                $routeName = 'messages.show';
                $routeParams = ['message'=>$notification->notifiable->id];
                }
                if($notification->is_seen === 0 ) $routeParams['is_seen'] = true;
                @endphp
                <a @class([ 'content' , 'active'=> $notification->is_seen ==0])
                    href="{{!empty($routeParams) ? route($routeName,$routeParams):"#"}}">{{$notification->message}}
                </a>
            </div>
        </div>
        @empty
        <div class="notification-item">

            <div class="info">
                <p style="margin:0px">لا يوجد اشعارات</p>
            </div>
        </div>
        @endforelse
    </div>

</div>