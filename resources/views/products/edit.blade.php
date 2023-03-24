@extends('layout.app')


@section('header-content')
    تعديل منتج
@endsection

@section('content')
    @if (!empty($errors->all()))
        <ul class='list-unstyled'>
            @foreach ($errors->all() as $error)
                <li class='alert alert-warning'>
                    {{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" class='mainform-app px-3 py-3' enctype='multipart/form-data'
        action="{{ route('products.update', ['product' => $product->id]) }}">
        @csrf
        @method('PUT')
        @include('products.form', ['product' => $product])

        <div class="mt-4 text-end">
            <button class="btn-add">
                <i class="icon fa fa-plus"></i>
                تعديل المنتج
            </button>
        </div>
    </form>
@endsection
