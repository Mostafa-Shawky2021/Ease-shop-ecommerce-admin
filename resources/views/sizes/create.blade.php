@extends('layout.app')

@section('header-content')
    <h5>اضافة مقاس جديد</h5>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <form action="{{ route('sizes.store') }}" class="mainform-app py-3 px-3"
                    id="sizesForm" method="post">
                    @csrf
                    <div class="">
                        <label class="label-control">اسم المقاس</label>
                        <div class="mt-3">
                            <input type="text" class="form-control" id="variantInput">
                            <input type="text" id="variantHiddenInput"
                                name="sizes_name" hidden />
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-dark" style="font-size:0.8rem"
                                id="addProductVariant">اضافة
                                عنصر جديد
                                <i class="icon fa fa-plus"></i>
                            </button>
                            <button class="btn-add d-block ms-auto" id="saveBtn"
                                style="border-radius:8px;font-size:0.8rem">
                                حفظ المقاس
                                <i class="icon fa fa-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
