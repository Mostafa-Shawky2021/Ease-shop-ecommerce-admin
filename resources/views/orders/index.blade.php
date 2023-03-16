@extends('layout.app')

@section('header-content')
    <h5>الاوردرات</h5>
@endsection

@section('content')
    <div>
        <div class='table-responsive '>
            {{ $dataTable->table(['class' => 'table table-data-layout']) }}
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
