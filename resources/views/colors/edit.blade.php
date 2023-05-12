@extends('layout.app')

@section('header-content')
<h5>تعديل لون </h5>
@endsection

@if (session()->has('message'))

<div class='alert alert-warning'>
    {{ session('message')[0] }}
</div>
@endif

@section('content')
@php $routeParamter = ['color'=> $color->id] ;@endphp

@foreach ($errors->all() as $error)
<div class="alert alert-warining">{{ $error }}</div>
@endforeach
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <form action="{{ route('colors.update', $routeParamter) }}" class="mainform-app py-3 px-3" id="colorsForm"
                method="post">
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