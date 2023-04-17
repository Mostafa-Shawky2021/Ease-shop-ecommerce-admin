@extends('layout.app')

@section('header-content')
    <h5>الاقسام</h5>
    <a class="btn-add" href="{{ route('categories.create') }}">
        اضافة قسم
        <i class="icon fa fa-plus"></i>
    </a>
@endsection


@section('content')
    <div class="datatable-wrapper" id="datatableWrapper">
        <div class="d-flex align-items-center justify-content-between">
            <div style="position:relative">
                <input id="searchDatatable" class="form-control search" placeholder="بحث" />
                <span class="icon-search"><i class="fa fa-search"></i></span>
            </div>
            <button id="delete-action">delete</button>
        </div>
        {{ $dataTable->table(['class' => 'table table-data-layout']) }}
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
