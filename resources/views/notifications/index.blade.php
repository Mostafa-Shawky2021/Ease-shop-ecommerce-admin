@extends('layout.app')

@section('header-content')
    <h5>الاشعارات</h5>
@endsection


@section('content')

      <div class="datatable-wrapper">
        @include('partials.datatableheader')
        <div class="table-responsive">
            <table class="table table-data-layout">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>اجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        
                        <tr>
                            <td>
                                @php 
                                $notificationStyle = $notification->status === 1
                                 ? 'var(--bs-primary)'
                                 : '#222'; 
                                @endphp
                                <a href="#" style="color:{{$notificationStyle}}">           {{$notification->message }}
                                </a>
                            </td>
                            <td>
                                <div class="action-wrapper" style="gap:9px">
                                    @php 
                                    $routeParams = ['order'=> $notification->order_id];
                                    if($notification->status === 1) {
                                      $routeParams['notification-status'] = 'active';
                                    }
                                   @endphp
                                    <a href="{{route('orders.show',$routeParams)}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if($notification->status === 1)
                                
                                        <form method="POST" action="{{route('notifications.update',['notification'=>$notification->id])}}"class="btn-action">
                                            <button class="btn-action">
                                                <i class="fa fa-check"></i>
                                            </button>
                                          
                                        </a>
                                    @endif
                                    <form method="POST" action="{{route('notifications.destroy',['notification'=>$notification->id])}}">
                                        @method('PUT')
                                        @csrf
                                        <button class="btn-action" alert="return confirm('هل انت متاكد؟!')">
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