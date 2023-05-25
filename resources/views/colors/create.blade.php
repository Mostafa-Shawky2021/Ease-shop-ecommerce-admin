@extends('layout.app')

@section('header-content')
<h5>اضافة لون جديد</h5>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-9">
            <form action="{{ route('colors.store') }}" class="mainform-app py-3 px-3" id="colorsForm" method="post">
                @csrf
                @include('colors.form', ['color' => null])
                <div class="mt-4">
                    <button class="btn btn-dark" style="font-size:0.8rem" id="addProductVariant">اضافة
                        عنصر جديد
                        <i class="icon fa fa-plus"></i>
                    </button>
                    <button class="btn-add d-block ms-auto mt-2" id="saveBtn" style="border-radius:8px;font-size:0.8rem">
                        حفظ اللون
                        <i class="icon fa fa-save"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection