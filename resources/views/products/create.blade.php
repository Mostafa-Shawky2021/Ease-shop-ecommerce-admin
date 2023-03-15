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
    <form class='mainform-app' id='addProductForm' enctype='multipart/form-data'
        method="post" action="{{ route('products.store') }}">
        @csrf
        <div class='row'>
            <div class="col-6">
                <label class='label-control' for="product-name">اسم المنتج</label>
                <input name='product_name' class="form-control mt-2"
                    id="product-name"value="{{ old('product_name') }}" />
            </div>
            <div class="col-6">
                <label class='label-control' for="brand">البراند</label>
                <input name='brand' id="brand" class="form-control mt-2"
                    autocomplete="off" value="{{ old('brand') }}" />
            </div>
        </div>
        <div class='row mt-4'>
            <div class="col-6">
                <label for="price" class='label-control'>السعر</label>
                <input id="price" name='price' value="{{ old('price') }}"
                    class="form-control mt-2" />
            </div>
            <div class="col-6">
                <label for="price-discount" class='label-control'>
                    السعر بعد الخصم
                </label>
                <input id='price-discount' name='priceDiscount'
                    value="{{ old('price_discount') }}" class="form-control mt-2" />
            </div>
        </div>
        <div class="mt-4">
            <label class='label-control'>الاقسام</label>
            <div class="col-6">
                <select class='form-control mt-2' name='category_id'>
                    <option value=''>...</option>
                    @forelse($categories as $category)
                        <option value={{ $category->id }}
                            {{ old('category_id') ?? 'checked' }}>
                            {{ $category->cat_name }}
                        </option>
                    @empty
                        <option disabled>لا يوجد اقسام للعرض</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-6">
                <label for="shortdescription" class='label-control'>
                    وصف مختصر للمنتج
                </label>
                <textarea id='shortdescription' name='short_description'
                    class='form-control short-description mt-2'>
                    {{ old('short_description') }}
                </textarea>
            </div>

        </div>
        <div class="row mt-4">
            <div class='col-8'>
                <label for="editor" class='label-control'>وصف المنتج</label>
                <textarea id='editor' name='long_description' class='form-control mt-2'>
                    {{ old('long_description') }}
                </textarea>
            </div>
        </div>

        {{-- <div class="row mt-4">
            <div class='col-6'>
                <label class='label-control'>اللون</label>
                <input type='text' id='color' name='color'
                    class='form-control mt-2' value="{{ old('color') }}" />
            </div>
            <div class="col-6">
                <label class="label-control">الحجم</label>
                <input type='text' id='color' name='size'
                    class='form-control mt-2' value="{{ old('size') }}" />
            </div>
        </div> --}}

        <div class="mt-4">
            <label class='label-control'>صورة المنتج</label>
            <div class='col-6 mt-2'>
                <div class="file-wrapper form-control">
                    <input type='file' name='image' id='productImage' />
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label class='label-control'>مصغرات المنتج</label>
            <div class='col-6 mt-2'>
                <div class="file-wrapper">
                    <input type='file' name='productImageThumbnails[]'
                        id='productImages' multiple />

                    <div class="description">Click To Upload Thumbnails</div>
                    <div class='file-content-show d-flex' id='boxImageShowmultiple'>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 text-end">
            <button class="btn-add">
                <i class="icon fa fa-plus"></i>
                اضافة المنتج
            </button>
        </div>
    </form>
    </div>
@endsection

@push('scripts')
    <script type="module">
    
    $('#editor').summernote({
        placeholder: 'Hello Bootstrap 5',
        tabsize: 2,
        height: 160,
      });
    </script>
@endpush
