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
                        <label class="label-control"> اللون</label>
                        <div class="mt-3">
                            <input type="color" id="variantInput" style="width:200px">
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
