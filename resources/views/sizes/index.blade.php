@extends('layout.app')

@section('header-content')
<h5>خيارات المقاسات</h5>
<a class="btn-add" href="{{ route('sizes.create') }}">
    اضافة مقاس
    <i class="icon fa fa-plus"></i>
</a>
@endsection

@section('content')

@include('partials.formmessage')

<div class="datatable-wrapper" id="sizesWrapper">
    <div class="d-flex justify-content-end">
        @include('partials.datatableheader')
    </div>
    <div class="table-responsive">
        <table class="table table-data-layout">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="multipleSelector">
                    </th>
                    <th>الاسم</th>
                    <th>اجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sizes as $size)
                @php $routeParamter = ['size' => $size->id] ;@endphp
                <tr>
                    <td>
                        <input value="{{ $size->id }}" type='checkbox' class="action-checkbox" />
                    </td>
                    <td>{{ $size->size_name }}</td>
                    <td>
                        <div class="action-wrapper">
                            <a class="btn-action" href="{{ route('sizes.edit', $routeParamter) }}">
                                <i class="fa fa-edit icon icon-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('sizes.destroy', $routeParamter) }}">
                                @method('DELETE')
                                @csrf
                                <button class="btn-action" onclick="return confirm('هل انت متاكد؟')">
                                    <i class="fa fa-trash icon icon-delete"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">لا توجد قيم لعرضها</td>
                </tr>
                @endforelse

            </tbody>
            {{ $sizes->links() }}
        </table>
    </div>
</div>
@endsection