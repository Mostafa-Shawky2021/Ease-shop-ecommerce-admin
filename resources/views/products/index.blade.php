@extends('layout.app')

@section('header-content')
    <h5>المنتجات</h5>
    <a class="btn-add" href="{{ route('products.create') }}">
        اضافة منتج
        <i class="icon fa fa-plus"></i>
    </a>
@endsection

@section('content')
    @php
        $productQuery = Request::query('status');
        $dataTableId = $productQuery === 'trashed' ? 'trashedProductsWrapper' : 'productsWrapper';
    @endphp
    <div class="datatable-wrapper" id="{{ $dataTableId }}">
        @php
            $datatableHeaderOptions = ['withSearch' => true];
            $datatableHeaderOptions = $productQuery === 'trashed' ? array_merge($datatableHeaderOptions, ['withRestoreBtn' => true]) : $datatableHeaderOptions;
            
        @endphp
        @include('partials.datatableheader', $datatableHeaderOptions)
        {{ $dataTable->table(['class' => 'table table-data-layout']) }}
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
