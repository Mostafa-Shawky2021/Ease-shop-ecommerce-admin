@extends('layout.app')
@php dd($test) @endphp
@section('header-content')
<h5> بيانات السليدر</h5>
<a class="btn-add" href="{{ route('carousel.create') }}">
    اضافة محتوي
    <i class="icon fa fa-plus"></i>
</a>
@endsection

@section('content')
<div class="table-responsive datatable-wrapper">
    <table class="table table-data-layout">
        <thead>
            <tr>
                <th>المحتوي</th>
                <th>مدة السليدر</th>
                <th>الصور</th>
                <th>أجراء</th>
            </tr>
        </thead>
        <tbody>
            @if (!$carouselHomePage)
            <tr>
                <td rowspan="4">لا توجد بيانات</td>
            </tr>
            @else
            <tr>
                <td style="text-align:right !important;">
                    {!! $carouselHomePage->content ?? 'لا يوجد' !!}
                </td>
                <td>{{ $carouselHomePage->carousel_time }}</td>
                <td>
                    @forelse($carouselHomePage->images as $image)
                    <img src="{{ $image->url }}" style="margin:0px 4px" width="50"
                        height="50" alt="carousel-image" />
                    @empty
                    لا يوجد
                    @endforelse
                </td>
                <td>
                    <div class="action-wrapper">
                        @php $routeParamter = ['carousel' => $carouselHomePage->id]
                        @endphp
                        <a class="btn-action"
                            href="{{ route('carousel.edit', $routeParamter) }}">
                            <i class="fa fa-edit icon icon-edit"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('carousel.destroy', $routeParamter) }}">
                            @method('DELETE')
                            @csrf
                            <button class="btn-action"
                                onclick="return confirm('هل انت متاكد؟')">
                                <i class="fa fa-trash icon icon-delete"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection