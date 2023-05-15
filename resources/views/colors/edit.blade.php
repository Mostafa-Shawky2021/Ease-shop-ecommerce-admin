@extends('layout.app')

@section('header-content')
<h5>تعديل لون </h5>
@endsection


@php $routeParamter = ['color'=> $color->id] ;@endphp

@section('content')

<div class="row">
    <div class="col-6">
        <form action="{{ route('colors.update', $routeParamter) }}" class="mainform-app py-3 px-2" id="colorsForm" method="post">
            @csrf
            @method('PUT')
            @include('colors.form', compact('color'))
            <div class="mt-4">
                <button class="btn-add d-block ms-auto" id="editBtn" style="border-radius:8px;font-size:0.8rem">
                    تعديل اللون
                    <i class="icon fa fa-edit"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection