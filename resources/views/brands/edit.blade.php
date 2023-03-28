@extends('layout.app')

@section('header-content')
    <h5>تعديل لون </h5>
@endsection


@section('content')
    @php $routeParamter = ['brand'=> $brand->id] ;@endphp

    @foreach ($errors->all() as $error)
        <div class="alert alert-warining">{{ $error }}</div>
    @endforeach
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <form action="{{ route('brands.update', $routeParamter) }}"
                    class="mainform-app py-3 px-3" method="post">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="label-control">اسم البراند</label>
                        <div class="mt-3">
                            <input type="text" class="form-control" name="brand_name"
                                id="variantInput" value="{{ $brand->brand_name }}">
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary"> تعديل</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
