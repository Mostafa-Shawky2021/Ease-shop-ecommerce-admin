@extends('layout.app')

@section('header-content')
    اضافة منتج
@endsection

@section('content')
    @if (!empty($errors->all()))
        <ul class='list-unstyled'>
            @foreach ($errors->all() as $error)
                <li class='alert alert-warning'>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    @endif
    <form class='mainform-app px-3 py-3' id='addProductForm' enctype='multipart/form-data'
        method="post" action="{{ route('products.store') }}">
        @csrf
        @include('products.form', ['product' => null])
        <div class="mt-4 text-end">
            <button class="btn-add">
                <i class="icon fa fa-plus"></i>
                اضافة المنتج
            </button>
        </div>
    </form>
    </div>
@endsection
