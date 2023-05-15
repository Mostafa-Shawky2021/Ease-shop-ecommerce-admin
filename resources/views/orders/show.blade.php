@extends('layout.app')

@php
// render orderstatus
$orderStatusText = '';
$orderStatusClass = '';
if ($order->order_status === 0) {
$orderStatusText = 'معلق';
$orderStatusClass = 'pending';
}
if ($order->order_status === 1) {
$orderStatusText = 'جاري التحضير';
$orderStatusClass = 'processing';
}

@endphp

@section('header-content')
<h5>تفاصيل الاوردر</h5>
@endsection

@section('content')

{{-- order Products --}}
<div class='order-products px-3 py-4'>
    <header class='products-header pb-4'>
        <div class="order-status">
            <span>حالة الطلب:</span>
            <span class='status {{ $orderStatusClass }}'>{{ $orderStatusText }}</span>
        </div>
    </header>
    <div class="datatable-wrapper">
        <div class="table-responsive">
            <table class="table-data-layout table">
                <thead>
                    <tr>
                        <th>صورة </th>
                        <th>اسم المنتج</th>
                        <th>اللون</th>
                        <th>المقاس</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>اجمالي السعر</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->products as $product)
                    @php
                    $productPrice = $product->price_discount ?? $product->price;
                    @endphp
                    <tr>
                        <td class="image">
                            <img width="30" height="30" src="{{ asset('storage/'.$product->image.'' )}}" alt="{{
                            $product->product_name }}" />
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->pivot->color ?? '--' }}</td>
                        <td>{{ $product->pivot->size ?? '--' }}</td>
                        <td> {{ number_format($productPrice) }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>
                            @php $totalProductPrice = $productPrice *
                            $product->pivot->quantity; @endphp
                            {{ number_format($totalProductPrice) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">لا توجد منتجات </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="customer-details py-4 px-3 mt-4">
    <h5 class='title'>
        <span class="ms-2">تفاصيل العميل </span>
    </h5>
    <ul class="list-unstyled list">
        <li class="item">
            <i class="fa fa-user icon"></i>
            <span>اسم العميل</span>:
            <span>{{$order->username}}</span>
        </li>
        <li class="item">
            <i class="fa fa-file icon"></i>
            <span>رقم الفاتورة</span>:
            <span>{{$order->invoice_number}}</span>
        </li>
        <li class="item">
            <i class="fa fa-phone icon"></i>
            <span>رقم التلفون</span>
            <span>:{{$order->phone}}</span>
        </li>
        <li class="item">
            <i class="fa-solid fa-house icon"></i>
            <span>العنوان</span>
            <span>:{{$order->street}}</span>
        </li>
        <li class="item">
            <i class="fa fa-location icon"></i>
            <span>المحافظة</span>
            <span>:{{$order->governorate}}</span>
        </li>
        <li class="item total-order-price">
            <i class="fa-solid fa-file-invoice-dollar icon"></i>
            <span>اجمالي سعر الفاتورة</span>
            <span>:{{ number_format($order->total_price) }}</span>
        </li>
        <li class="item order-notes">
            <i class="fa-regular fa-note-sticky icon"></i>
            <span>ملاحظات بخصوص الاوردر:</span>
            <p>{{ $order->order_notes ? $order->order_notes : 'لا يوجد تفاصيل' }}
            </p>
        </li>
    </ul>
    <form method="POST" action="{{ route('orders.update', ['order' => $order->id]) }}">
        @csrf
        @method('PUT')
        <div class="d-flex align-items-center">
            <label for="">تغير الحالة</label>
            <select id="orderStatus" name="status" class="form-select py-1 px-1 ms-3">
                <option value="0" @selected(0===$order->order_status)>
                    معلق
                </option>
                <option value="1" @selected(1===$order->order_status)>
                    جاري التحضير
                </option>
            </select>
            @error('status')
            <div class="alert alert-danger">{{ $message }} </div>
            @enderror
        </div>
        <div class="mt-3 text-end">
            <button class="btn btn-primary">حفظ</button>
        </div>
    </form>
</div>
@endsection