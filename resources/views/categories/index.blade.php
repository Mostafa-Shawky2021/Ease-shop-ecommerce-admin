@extends('layout.app')

@section('header-content')
    <h5>الاقسام</h5>
    <a class="btn-add" href="{{ route('categories.create') }}">
        اضافة قسم
        <i class="icon fa fa-plus"></i>
    </a>
@endsection


@section('content')
    <div class="datatable-wrapper" id="categoriesWrapper">
        @include('partials.datatableheader', ['withSearch' => true])
        {{ $dataTable->table(['class' => 'table table-data-layout']) }}
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
