@extends('layout.app')

@section('header-content')
اضافة قسم
@endsection

@section('content')
<form class='mainform-app px-3 py-3' method="post" enctype='multipart/form-data'
    action="{{ route('categories.update', ['category' => $category->id]) }}">
    @csrf
    @method('PUT')
    @include('categories.form', ['category' => $category])
    <div class="mt-4 text-end">
        <button class="btn-add">
            تعديل قسم
            <i class="icon fa fa-edit"></i>
        </button>
    </div>
</form>

@endsection