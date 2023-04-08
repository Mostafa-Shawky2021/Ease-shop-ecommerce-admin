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
                    <div>
                        <label class="label-control">اسم اللون</label>
                        <div class="mt-3">
                            <input type="text" class="form-control"
                                id="variantInput" />
                            <input type="text" id="variantHiddenInput"
                                name="colors_name" hidden />
                        </div>
                    </div>
                    <div class="mt-3 color-picker-wrapper">
                        <label class="label-control">قيمة اللون</label>
                        <div class="mt-3">
                            <input type="text" class="color-picker" name=""
                                id="colorValue" />
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-dark" style="font-size:0.8rem"
                                id="addProductVariant">اضافة
                                عنصر جديد
                                <i class="icon fa fa-plus"></i>
                            </button>
                            <button class="btn-add d-block ms-auto" id="saveBtn"
                                style="border-radius:8px;font-size:0.8rem">
                                حفظ اللون
                                <i class="icon fa fa-save"></i>
                            </button>
                        </div>

                </form>
            </div>
        </div>
    @endsection
