@extends('layout.app')

@section('header-content')
<h5>خيارات الالون</h5>
<a class="btn-add" href="{{ route('colors.create') }}">
    اضافة لون
    <i class="icon fa fa-plus"></i>
</a>
@endsection


@section('content')
<div class="datatable-wrapper" id="colorsWrapper">
    <div class="d-flex justify-content-end">
        @include('partials.datatableheader')
    </div>
    @if (session()->has('message'))

    <div class='alert alert-warning'>
        {{ session('message')[0] }}
    </div>
    @endif
    <div class="table-responsive">
        <table class="table table-data-layout">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="multipleSelector">
                    </th>
                    <th>الاسم</th>
                    <th>قيمة اللون</th>
                    <th>اجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($colors as $color)
                @php $routeParamter = ['color' => $color->id] ;@endphp
                <tr>
                    <td>
                        <input value="{{ $color->id }}" type='checkbox' class='action-checkbox' />
                    </td>
                    <td>{{ $color->color_name }}</td>
                    <td>
                        <span style="width:15px;height:15px;background:{{ $color->color_value }}">
                        </span>
                    </td>
                    <td>
                        <div class="action-wrapper">
                            <a class="btn-action" href="{{ route('colors.edit', $routeParamter) }}">
                                <i class="fa fa-edit icon icon-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('colors.destroy', $routeParamter) }}">
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
        </table>
        {{ $colors->links() }}
    </div>
</div>
@endsection