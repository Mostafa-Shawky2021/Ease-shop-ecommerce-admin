@extends('layout.app')

@section('header-content')
    المنتجات
@endsection

@section('content')
    <div class="content">
        <header class="inner-content-header">
            {{-- <a class="btn-add" href="{{ route('products.create') }}">
                اضافة منتج
                <i class="icon fa fa-plus"></i>
            </a> --}}
        </header>

        {{ $dataTable->table(['class' => 'table table-data-layout'], true) }}


    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
