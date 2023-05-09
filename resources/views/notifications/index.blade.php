@extends('layout.app')

@section('header-content')
<h5>الاشعارات</h5>
@endsection


@section('content')

<div class="datatable-wrapper" id="notificationsWrapper">
    <div class="d-flex justify-content-end">
        @include('partials.datatableheader')
    </div>
    <div class="table-responsive">
        <table class="table table-data-layout">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="multipleSelector">
                    </th>
                    <th>الاسم</th>
                    <th>اجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                @php
                $routeName = "";
                $routeParams = [];
                if($notification->notifiable instanceof \App\Models\Order ) {
                $routeName = 'orders.show';
                $routeParams = ['order'=>$notification->notifiable->id];
                } else {
                $routeName = 'messages.show';
                $routeParams = ['message'=>$notification->notifiable->id];
                }

                if($notification->is_seen === 0 ) $routeParams['is_seen'] =
                true;
                @endphp
                <tr>
                    <td>
                        <input value="{{ $notification->id }}" type='checkbox'
                            class='action-checkbox' />
                    </td>
                    <td>
                        @php
                        $notificationStyle = $notification->is_seen === 0
                        ? 'var(--bs-primary)'
                        : '#222';
                        @endphp
                        <a href="{{route($routeName,$routeParams)}}"
                            style="color:{{$notificationStyle}}">
                            {{$notification->message }}
                        </a>
                    </td>
                    <td>
                        <div class="action-wrapper" style="gap:9px">
                            <a href="{{route($routeName,$routeParams)}}">
                                <i class="fa fa-eye"></i>
                            </a>

                            @if($notification->is_seen === 0)

                            <form method="POST"
                                action="{{route('notifications.update',['notification'=>$notification->id])}}"
                                class="btn-action">
                                @method('PUT')
                                @csrf
                                <button class="btn-action">
                                    <i class="fa fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <form method="POST"
                                action="{{route('notifications.destroy',['notification'=>$notification->id])}}">
                                @method('DELETE')
                                @csrf
                                <button class="btn-action"
                                    onclick="return confirm('هل انت متاكد؟!')">
                                    <i class="fa fa-trash icon icon-delete"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">لا توجد قيم لعرضها</td>
                </tr>
                @endforelse

            </tbody>
            {{ $notifications->links() }}
        </table>
    </div>
</div>
@endsection