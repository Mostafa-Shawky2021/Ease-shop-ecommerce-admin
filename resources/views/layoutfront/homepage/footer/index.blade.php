@extends('layout.app')

@section('header-content')
<h5>محتوي الفوتر</h5>
@if(!$footer)
<a class="btn-add" href="{{route('footer.create')}}">
    اضافة
    <i class="fa fa-plus"></i>
</a>
@endif
@endsection


@section('content')
<div class="footer-content"
    style="max-width:700px; background:#fff; padding:1.3rem 1rem 2.4rem; position:relative">
    @if($footer)
    <ul class="list-unstyled">
        <li style="position:absolute; left:10px; bottom: 10px" class="d-flex gap-1">
            <a class="btn-add"
                href="{{route('footer.edit',['footer'=>$footer->id])}}">تعديل
                <i class="fa fa-edit"></i>
            </a>
            <form method="post"
                action="{{route('footer.destroy',['footer'=>$footer->id])}}">
                @csrf
                @method('DELETE')
                <button class="btn-delete"
                    onclick="return confirm('هل انت متاكد من الحذف؟!')">حذف
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </li>
        <li class="item d-flex flex-wrap gap-1">
            <i class="fa fa-user icon me-2 mt-1"></i>
            <div class="gap-1 d-flex">
                <span>من نحن</span>:
                <p>{{$footer->aboutus}}</p>
            </div>
        </li>
        <li class="item d-flex flex-wrap gap-1 mt-2">
            <i class="fa fa-location icon me-2 mt-1"></i>
            <div class="d-flex gap-1">
                <span>العنوان: </span>
                <p>{{$footer->address ?? 'لا يوجد' }}</p>
            </div>
        </li>
        <li class="item d-flex flex-wrap gap-1 mt-2">
            <i class="fa fa-phone icon me-2 mt-1"></i>
            <div class="d-flex gap-1">
                <span>التلفون: </span>
                <p>{{$footer->phone ?? 'لا يوجد'}}</p>
            </div>
        </li>
        <li class="item d-flex flex-wrap gap-1 mt-2">
            <i class="fa fa-phone icon me-2 mt-1"></i>
            <div class="d-flex gap-1">
                <span>رقم الواتس: </span>
                <p>{{$footer->whatsapp_number ?? 'لا يوجد'}}</p>
            </div>
        </li>
        <li class="item d-flex flex-wrap gap-1 mt-2">
            <i class="fa-brands fa-facebook icon me-2 mt-1"></i>
            <div class="d-flex gap-1">
                <span> facebook: </span>
                <p>
                    @if($footer->facebook_link)
                    <a target="_blank"
                        href="{{$footer->facebook_link}}">{{$footer->facebook_link}}</a>
                    @else
                    لا يوجد
                    @endif
                </p>
            </div>

        </li>
        <li class="item d-flex flex-wrap gap-1 mt-2">
            <i class="fa-brands fa-twitter icon me-2 mt-1"></i>
            <div class="d-flex gap-1">
                <span>twitter:</span>
                <p>
                    @if($footer->twitter_link)
                    <a target="_blank"
                        href="{{$footer->twitter_link}}">{{$footer->twitter_link}}</a>
                    @else
                    لا يوجد
                    @endif
            </div>
        </li>
        <li class="item d-flex flex-wrap gap-1 mt-2">
            <i class="fa-brands fa-google icon me-2 mt-1"></i>
            <div class="d-flex gap-1">
                <span>gmail:</span>
                <p>
                    @if($footer->gmail_link)
                    <a target="_blank"
                        href="{{$footer->gmail_link}}">{{$footer->gmail_link}}</a>
                    @else
                    لا يوجد
                    @endif
                </p>
            </div>
        </li>
    </ul>
    @else
    <p>لا يوجد محتوي اضغط علي زر اضافة</p>
    @endif


</div>


@endsection