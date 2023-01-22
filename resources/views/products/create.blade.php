@extends('layout.app')
@section('content')

    <div class="category-add-wrapper">
        <header class="inner-content-header">
            <h4 class="title">New Product</h4>
        </header>

        @if (!empty($errors->all()))
            <ul class='list-unstyled'>
                @foreach ($errors->all() as $error)
                    <li class='alert alert-warning'>
                        {{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form class='category-add-form' id='addProductForm' enctype='multipart/form-data'
            method="post" action="{{ route('products.store') }}">
            @csrf
            <div class='row align-items-center'>
                <div class='col-12 col-sm-2'>
                    <label class='label-control'>Productname</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input name='productName' value="{{ old('productName') }}"
                        type='text'class="form-control"
                        placeholder="Enter product name" />
                </div>
            </div>
            <div class='mt-4 row align-items-center'>
                <div class='col-12 col-sm-2'>
                    <label for="brand" class='label-control'>Brandname</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input id="brand" name='brandName' value="{{ old('brandName') }}"
                        type='text' class="form-control"
                        placeholder="Enter Brand name" />
                </div>
            </div>
            <div class='mt-4 row align-items-center'>
                <div class='col-12 col-sm-2'>
                    <label for="price" class='label-control'>Price</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input id="price" name='price' value="{{ old('price') }}"
                        type='number' class="form-control" placeholder="Enter price" />
                </div>
            </div>
            <div class='mt-4 row align-items-center'>
                <div class='col-12 col-sm-2'>
                    <label for="price-discount"class='label-control'>Price
                        discount</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input id='price-discount' name='priceDiscount'
                        value="{{ old('priceDiscount') }}" type='number'
                        class="form-control" placeholder="Enter price discount" />
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label for="shortdescription" class='label-control'>Short
                        description</label>
                </div>
                <div class="col-12 col-sm-10">
                    <textarea id='shortdescription' name='shortDescription' class='form-control'>{{ old('shortDescription') }}</textarea>
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label for="description" class='label-control'>Description</label>
                </div>
                <div class="col-12 col-sm-10">
                    <textarea id='description' name='description' class='form-control'>{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label class='label-control'>Category</label>
                </div>
                <div class="col-12 col-sm-10">
                    <select class='form-control' name='categoryId'>
                        <option value=''>...</option>
                        @forelse($categories as $category)
                            <option value={{ $category->id }}
                                {{ old('categoryId') ? 'checked' : '' }}>
                                {{ $category->cat_name }}
                            </option>
                        @empty
                            <option disabled>Sorry No
                                Categories</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label class='label-control'>Color</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input type='text' id='color' name='color'
                        class='form-control' placeholder="enter color seperated by,"
                        value="{{ old('color') }}" />
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label class='label-control'>Size</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input type='text' id='color' name='size'
                        class='form-control' placeholder="enter size seperated by,"
                        value="{{ old('size') }}" />
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label class='label-control'>Image product</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <div class="file-wrapper">
                        <input type='file' name='productImage'
                            id='productImageFileBrand' />
                        <div class="description">Click To Upload Image</div>
                        <div class='file-content-show' id='boxImageShow'></div>
                    </div>
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label class='label-control'>Product Thumbnails</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <div class="file-wrapper">
                        <input type='file' name='productImageThumbnails[]'
                            id='productImageThumbnails' multiple />

                        <div class="description">Click To Upload Thumbnails</div>
                        <div class='file-content-show d-flex'
                            id='boxImageShowmultiple'></div>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-end">
                <button class="btn-add"><i class="icon fa fa-plus"></i>Add
                    Product</button>
            </div>

        </form>
    </div>
@endsection
