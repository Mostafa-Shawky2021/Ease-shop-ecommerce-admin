@extends('layout.app')

@section('header-content')
اضافة محتوي السليدر
@endsection

@section('content')

<form class='mainform-app px-3 py-3' style="margin-top:1rem;" enctype='multipart/form-data' method="post"
    action="{{ route('carousel.update', ['carousel' => $carousel->id]) }}">
    @csrf
    @method('PUT')
    @include('layoutfront.homepage.carousel.form', [
    'carousel' => $carousel,
    ])
    <div class="mt-4 text-end">
        <button class="btn-add">
            تعديل المحتوي
            <i class="icon fa fa-plus"></i>
        </button>
    </div>
</form>
@endsection