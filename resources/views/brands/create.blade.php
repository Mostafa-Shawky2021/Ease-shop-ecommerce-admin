@extends('layout.app')

@section('header-content')
    <h5>اضافة براند جديد</h5>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <form action="{{ route('brands.store') }}" class="mainform-app py-3 px-3"
                    id="brandsForm" method="post">
                    @csrf
                    <div>
                        <label class="label-control">اسم البراند</label>
                        <div class="mt-3">
                            <input type="text" class="form-control" id="variantInput">
                            <input type="text" id="variantHiddenInput"
                                name="brands_name" hidden />
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-dark" style="font-size:0.8rem"
                                id="addProductVariant">اضافة
                                عنصر جديد
                                <i class="icon fa fa-plus"></i>
                            </button>
                            <button class="btn-add d-block ms-auto" id="saveBtn"
                                style="border-radius:8px;font-size:0.8rem">
                                حفظ البراند
                                <i class="icon fa fa-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
