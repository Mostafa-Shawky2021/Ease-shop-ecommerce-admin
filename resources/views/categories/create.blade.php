@extends('layout.app')

@section('header-content')
    اضافة منتج
@endsection

@section('content')
    @if (!empty($errors->all()))
        <ul class='list-unstyled'>
            @foreach ($errors->all() as $error)
                <li class='alert alert-warning'>
                    {{ $error }}</li>
            @endforeach
        </ul>
    @endif


    <form class='mainform-app px-3 py-3' method="post" enctype='multipart/form-data'
        action="{{ route('categories.store') }}">
        @csrf
        <div>
            <label class='label-control'>اسم القسم</label>
            <div class='col-6 mt-2'>
                <input type='text' class="form-control" name='categoryName' />
            </div>
        </div>
        <div class="mt-4">
            <label for="description" class='label-control'>وصف القسم</label>
            <div class="col-6 mt-2">
                <textarea id='description' name='description' class='form-control'></textarea>
            </div>
        </div>
        <div class="mt-4">
            <div class='col-6'>
                <label class='label-control'>القسم الرئيسي</label>
            </div>
            <div class="col-12 col-sm-10">
                <select class='form-control' name='categoryParent'>
                    <option value=''>...</option>
                    @forelse($categories as $category)
                        <option value={{ $category->id }}>{{ $category->cat_name }}
                        </option>
                    @empty
                        <option disabled>Sorry No Categories</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="mt-4">
            <label for="image-category" class='label-control'>Image
                صورة القسم</label>
            <div class='col-6'>
                <input id="image-category" type='file' name='categoryImage' />
            </div>
        </div>
        <div class="mt-4 text-end">
            <button class="btn-add">
                <i class="icon fa fa-plus"></i>
                اضافة قسم</button>
        </div>

    </form>
    </>

@endsection
