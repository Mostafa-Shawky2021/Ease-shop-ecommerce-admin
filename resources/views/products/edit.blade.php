@extends('layout.app')
@section('content')

    <div class="product-add-wrapper">
        <header class="inner-content-header">
            <h4 class="title">Edit Product</h4>
        </header>

        @if (!empty($errors->all()))
            <ul class='list-unstyled'>
                @foreach ($errors->all() as $error)
                    <li class='alert alert-warning'>
                        {{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form class='category-add-form' enctype='multipart/form-data' method="post"
            action="{{ route('products.update', ['product' => $product->id]) }}">
            @csrf
            <div class='row align-items-center'>
                <div class='col-12 col-sm-2'>
                    <label class='label-control'>Product name</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input name='productName' value="{{ $product->product_name }}"
                        type='text'class="form-control"
                        placeholder="Enter product name" />
                </div>
            </div>
            <div class='mt-4 row align-items-center'>
                <div class='col-12 col-sm-2'>
                    <label for="brand" class='label-control'>Brand name</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input id="brand" name='brandName' value="{{ $product->brand }}"
                        type='text' class="form-control"
                        placeholder="Enter Brand name" />
                </div>
            </div>
            <div class='mt-4 row align-items-center'>
                <div class='col-12 col-sm-2'>
                    <label for="price" class='label-control'>Price</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input id="price" name='price' value="{{ $product->price }}"
                        type='number' class="form-control" placeholder="Enter price" />
                </div>
            </div>
            <div class='mt-4 row align-items-center'>
                <div class='col-12 col-sm-2'>
                    <label
                        for="price-discount"class='label-control'>Pricediscount</label>
                </div>
                <div class='col-12 col-sm-10'>
                    <input id='price-discount' name='priceDiscount'
                        value="{{ $product->price_discount ? $product->price_discount : '' }}"
                        type='number' class="form-control"
                        placeholder="Enter price discount" />
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label for="description" class='label-control'>Description</label>
                </div>
                <div class="col-12 col-sm-10">
                    <textarea id='description' name='description' class='form-control'>{{ $product->long_description }}</textarea>
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label for="shortdescription" class='label-control'>Short
                        description</label>
                </div>
                <div class="col-12 col-sm-10">
                    <textarea id='shortdescription' name='shortDescription' class='form-control'>{{ $product->short_description }}</textarea>
                </div>
            </div>
            <div class="mt-4 row align-items-center">
                <div class='col-12 col-sm-2'>
                    <label class='label-control'>Category</label>
                </div>
                <div class="col-12 col-sm-10">
                    <select class='form-control' name='categoryId'>
                        <option value=''>...</option>
                        @foreach ($categories as $category)
                            <option value={{ $category->id }}
                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->cat_name }}
                            </option>
                        @endforeach
                    </select>
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
                        <div class='file-content-show' id='boxImageShow'>
                            @if ($product->image)
                                <div class='img-box old'>
                                    <img class='img'
                                        src={{ asset("storage/{$product->image}") }}
                                        alt='product-image' />
                                </div>
                            @endif
                        </div>
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
                        <div class='file-content-show d-flex' id='boxImageShowmultiple'>
                            @unless(empty($product->images))
                                @foreach ($product->images as $image)
                                    <div class='img-box old'>
                                        <img class='img'
                                            src={{ asset("storage/{$image->url}") }}
                                            alt='product-image' />
                                    </div>
                                @endforeach
                            @endunless
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-end">
                <button class="btn-add"><i class="icon fa fa-plus"></i>Edit
                    Product</button>
            </div>

        </form>
    </div>


@endsection
