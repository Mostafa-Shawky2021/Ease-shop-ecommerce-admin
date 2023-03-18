@extends('layout.app')

@section('header-content')
    <h5>اضافة لون جديد</h5>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <form action="{{ route('colors.store') }}" class="mainform-app py-3 px-3"
                    id="colorsForm" method="post">
                    @csrf
                    <div class="">
                        <label class="label-control">اسم اللون</label>
                        <div class="mt-3">
                            <input type="text" class="form-control" id="variantInput">
                            <input type="text" id="variantHiddenInput"
                                name="colors_name" hidden />
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary" id="addProductVariant">اضافة
                                عنصر
                                جديد</button>
                            <button class="btn btn-primary" id="saveBtn">
                                حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
