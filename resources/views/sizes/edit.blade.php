@extends('layout.app')

@section('header-content')
    <h5>تعديل مقاس </h5>
@endsection


@section('content')
    @php $routeParamter = ['size'=> $size->id] ;@endphp

    @foreach ($errors->all() as $error)
        <div class="alert alert-warining">{{ $error }}</div>
    @endforeach
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <form action="{{ route('sizes.update', $routeParamter) }}"
                    class="mainform-app py-3 px-3" method="post">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="label-control">اسم المقاس</label>
                        <div class="mt-3">
                            <input type="text" class="form-control" name="size_name"
                                id="variantInput" value="{{ $size->size_name }}">
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary"> تعديل</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
