@php

$colorsArrToString = $product ? $product->colors->map(fn($color) =>
$color->id)->implode('|') : '';
$sizesArrToString = $product ? $product->sizes->map(fn($size) => $size->id)->implode('|')
: '';
$colorsId = old('color_id', $colorsArrToString);
$sizesId = old('size_id', $sizesArrToString);
@endphp

@include('partials.validationerrors')


<div class='row'>
    <div class="col-12 col-sm-6 mt-3">
        <label class='label-control' for="product-name">اسم المنتج</label>
        <input name='product_name' class="form-control mt-2" id="product-name"
            value="{{ old('product_name', $product->product_name ?? '') }}" />
    </div>
    <div class="col-12 col-sm-6 mt-3">
        <div class="d-flex justify-content-between">
            <label class='label-control' for="brand">البراند</label>
            <a class="btn btn-add-fast" data-bs-toggle="modal" data-bs-target="#productBrandModal">اضافة
                براند</a>
        </div>
        {{-- brand modal for send brand value with ajax --}}
        @include('products.variantmodal', [
        'id' => 'productBrandModal',
        'title' => 'اضافه براند',
        'labelName' => 'اسم البراند',
        ])
        <select class='form-control mt-2' name='brand_id' id="brand">
            <option value=''>...</option>
            @forelse($brands as $brand)
            <option value={{ $brand->id }} @selected(old('brand_id', $product->brand->id
                ?? '') == $brand->id)>
                {{ $brand->brand_name }}
            </option>
            @empty
            <option disabled>لا يوجد براندات للعرض</option>
            @endforelse
        </select>
    </div>
</div>
<div class='row'>
    <div class="col-12 col-sm-6 mt-3">
        <label for="price" class='label-control'>السعر</label>
        <input id="price" name='price' value="{{ old('price', $product->price ?? '') }}" class="form-control mt-2" />
    </div>
    <div class="col-12 col-sm-6 mt-3">
        <label for="price-discount" class='label-control'>
            السعر بعد الخصم
        </label>
        <input id='price-discount' name='price_discount' value="{{ old('price_discount', $product->price_discount ?? '') }}"
            class="form-control mt-2" />
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-12 col-md-8 mt-3">
        <div class="d-flex justify-content-between">
            <label class='label-control' for="category">الاقسام</label>
            <a class="btn btn-add-fast" data-bs-toggle="modal" data-bs-target="#productCategoryModal">اضافة
                قسم</a>
        </div>
        {{-- category modal for send brand value with ajax --}}
        @include('products.variantmodal', [
        'id' => 'productCategoryModal',
        'title' => 'اضافه قسم',
        'labelName' => 'اسم القسم',
        ])
        <select class='form-control mt-2' name='category_id' id="category">
            <option value=''>...</option>
            @forelse($categories as $category)
            <option value={{ $category->id }} @selected(old('category_id',
                $product->category_id ?? '') == $category->id)>
                {{ $category->cat_name }}
            </option>
            @empty
            <option disabled>لا يوجد اقسام للعرض</option>
            @endforelse
        </select>

    </div>


</div>
<div class="row">
    <div class="col-sm-12 col-md-8 mt-3">
        <label for="shortdescription" class='label-control'>
            وصف مختصر للمنتج
        </label>
        <textarea id='shortdescription' name='short_description' class='form-control short-description mt-2'>
            {{ old('short_description', $product->short_description ?? '') }}
        </textarea>
    </div>
</div>
<div class="row">
    <div class='col-sm-12 col-md-8 mt-3'>
        <label for="editor" class='label-control'>وصف المنتج</label>
        <textarea id='editor' name='long_description' class='form-control mt-2'>
            {{ old('long_description', $product->long_description ?? '') }}
        </textarea>
    </div>
</div>
<div class="mt-4 mt-md-3">
    <label class='label-control'>صورة المنتج</label>
    <div class='col-sm-12 col-md-8 mt-2'>
        <div class="file-wrapper form-control">
            <input name="old_image" id="oldImage"
                value="{{ $product && $product->image ? asset('storage/' . $product->image) : '' }}" hidden />
            <input type='file' name='image' id='productImage' accept="image/*" />
        </div>
    </div>
</div>
<div class="mt-4 mt-md-3">
    <label class='label-control'>مصغرات المنتج</label>
    <div class='col-sm-12 col-md-8 mt-2'>
        <div class="file-wrapper">
            @php
            $thumbnailsImages = null;
            if ($product && $product->images->isNotEmpty()) {
            $thumbnailsImages = $product->images->map(fn($image) => asset('storage/' .
            $image->url))->implode('|');
            }
            @endphp
            <input name="old_images" id="oldImage" value="{{ $thumbnailsImages }}" hidden />
            <input type='file' name='productImageThumbnails[]' id='productImages' accept="image/*" multiple />
        </div>
    </div>
</div>

{{-- <h5 class="options" style="margin-top:1.5rem;padding-top:1rem; border-top: 1px solid #e0e0e0; font-size: 1rem;">
    الخيارات
</h5> --}}
<div class="mt-3 row pb-3 pt-3" style="border-bottom:1px solid #dedede">
    <div class="col-sm-12 col-md-8">
        <div class="d-flex justify-content-between">
            <label class='label-control'>الالوان</label>
            <a class="btn btn-add-fast" data-bs-toggle="modal" data-bs-target="#productColorModal">اضافة لون</a>
        </div>
        <div id="selectColorsOtionsWrapper" class="d-flex gap-3 mt-2">
            {{-- will used by javascript to inject colors value --}}
            <input name="color_id" id="variantHiddenInput" hidden value="{{ $colorsId }}" />
            {{-- color modal for send brand value with ajax --}}
            @include('products.variantmodal', [
            'id' => 'productColorModal',
            'title' => 'اضافه لون',
            'labelName' => 'اسم اللون',
            'color_picker' => true
            ])
            <div class="d-flex align-items-center gap-3 flex-wrap" id="boxWrapper">
                @forelse ($colors as $color)
                <div class="product-variant" value="{{ $color->id }}">
                    {{ $color->color_name }}
                </div>
                @empty
                <div class="m-0" disabled="true">لا يوجد</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<div class='row pt-2'>
    <div class="col-sm-12 col-md-8 mt-3">
        <div class="d-flex justify-content-between">
            <label class='label-control'>المقاسات</label>
            <a class="btn btn-add-fast" data-bs-toggle="modal" data-bs-target="#productSizeModal">اضافة مقاس</a>
        </div>
        <div id="selectSizesOptionWrapper" class="d-flex gap-3 mt-2">
            {{-- will used by javascript to inject sizes value --}}
            <input name="size_id" id="variantHiddenInput" value="{{ $sizesId }}" hidden />
            {{-- size modal for send brand value with ajax --}}
            @include('products.variantmodal', [
            'id' => 'productSizeModal',
            'title' => 'اضافه مقاس',
            'labelName' => 'اسم المقاس',
            ])
            <div class="d-flex align-items-center gap-3 flex-wrap" id="boxWrapper">
                @forelse ($sizes as $size)
                <div class="product-variant" value="{{ $size->id }}">
                    {{ $size->size_name }}
                </div>
                @empty
                <div class="m-0" disabled="true">لا يوجد</div>
                @endforelse
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script type="module">
    $('#editor').summernote({
        placeholder: 'Write Here!',
        lineHeights:['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
        fontSizes:['15','17','20','23','27','33','35','38','42','45','48','50'],
        tabsize: 2,
        height: 200,
        toolbar: [
          ['style', ['italic', 'underline','clear']],
          ['fontsize', ['fontsize']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph','height','style']],
          ['insert', ['link', 'picture', 'video','hr']],
          ['view', ['fullscreen', 'help','undo','redo']]
        ]
      });

</script>
@endpush