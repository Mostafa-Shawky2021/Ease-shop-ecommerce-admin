@extends('layout.app')

@section('header-content')
    <h5>الاوردرات</h5>
@endsection

@section('content')
    <div>
        {{ $dataTable->table(['class' => 'table table-data-layout']) }}
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
