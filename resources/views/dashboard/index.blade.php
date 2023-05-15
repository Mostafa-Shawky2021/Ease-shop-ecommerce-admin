@extends('layout.app')
@section('content')
<div class="container-fluid fast-analysis">
    <div class="row">
        <div class="col-3">
            <div class="total-products d-flex justify-content-between px-4 py-4 box">
                <div class="info">
                    <p class="count">{{$productsCount}}</p>
                    <p class="data">
                        <a href="{{route('products.index')}}">المنتجات</a>
                    </p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-shop"></i>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="pending-orders d-flex justify-content-between px-4 py-4 box">
                <div class="info">
                    <p class="count">{{$pendingOrders}}</p>
                    <p class="data">
                        <a href="{{route('orders.index')}}">
                            الاوردارات المعلقة
                        </a>
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="completed-orders d-flex justify-content-between px-4 py-4 box">
                <div class="info">
                    <p class="count">{{$completedOrders}}</p>
                    <p class="data">الاوردارات المكتملة</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="total-categories d-flex justify-content-between px-4 py-4 box">
                <div class="info">
                    <p class="count">{{$categoriesCount}}</p>
                    <p class="data">الاقسام</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tags"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="lastest-orders">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>اسم العميل</th>
                        <th>رقم التلفون</th>
                        <th>المحافظة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestOrders as $latestOrder)
                    <tr>
                        @php
                        $routeParams = ['order'=>$latestOrder->id]
                        @endphp
                        <td>
                            <a href="{{route('orders.show',$routeParams)}}">
                                {{$latestOrder->invoice_number}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('orders.show',$routeParams)}}">
                                {{$latestOrder->username}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('orders.show',$routeParams)}}">
                                {{$latestOrder->phone}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('orders.show',$routeParams)}}">
                                {{$latestOrder->governorate}}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">لا توجد اوردرات بعد</td>
                    </tr>
                    @endforelse
                    @if($latestOrders->isNotEmpty())
                    <td rowspan="4">
                        <a class="show-more" href="{{route('orders.index')}}" class="btn btn-primary btn-sm">عرض المزيد</a>
                    </td>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection