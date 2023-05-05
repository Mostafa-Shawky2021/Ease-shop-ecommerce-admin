<div class="notification-list-wrapper"  id="collapseList">
    <h6 class="title">
        <span>
            الاشعارات
            <i class="fa fa-bell" style="color:#2a3042;margin:0px 5px"></i>
        </span>
        <span>
            <a href="#" class="view-more">...عرض المزيد</a>
        </span>
    </h6>
    <div class="notification-list">
        @forelse($notifications as $notification)
        <div class="notification-item">
            <div class="icon-cart">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="info">
                <a @class([ 'content' , 'active'=> $notification->status ==1])
                    href="{{route('orders.show',['order'=>$notification->id,'notification-status'=>'active'])}}">{{$notification->message}}</a>
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