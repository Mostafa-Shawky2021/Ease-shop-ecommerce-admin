@php
    
    $colorsArrToString = $product ? $product->colors->map(fn($color) => $color->id)->implode('|') : '';
    $sizesArrToString = $product ? $product->sizes->map(fn($size) => $size->id)->implode('|') : '';
    $colorsId = old('color_id', $colorsArrToString);
    $sizesId = old('size_id', $sizesArrToString);
    
@endphp
<div class='row'>
    <div class="col-6">

        <label class='label-control' for="product-name">اسم المنتج</label>
        <input name='product_name' class="form-control mt-2" id="product-name"
            value="{{ old('product_name', $product->product_name ?? '') }}" />
    </div>
    <div class="col-6">
        <label class='label-control' for="brand">البراند</label>
        <input name='brand' id="brand" class="form-control mt-2"
            autocomplete="off" value="{{ old('brand', $product->brand ?? '') }}" />
    </div>
</div>
<div class='row mt-4'>
    <div class="col-6">
        <label for="price" class='label-control'>السعر</label>
        <input id="price" name='price'
            value="{{ old('price', $product->price ?? '') }}"
            class="form-control mt-2" />
    </div>
    <div class="col-6">
        <label for="price-discount" class='label-control'>
            السعر بعد الخصم
        </label>
        <input id='price-discount' name='price_discount'
            value="{{ old('price_discount', $product->price_discount ?? '') }}"
            class="form-control mt-2" />
    </div>
</div>

<div class="mt-4">
    <label class='label-control'>الاقسام</label>
    <div class="col-6">
        <select class='form-control mt-2' name='category_id'>
            <option value=''>...</option>
            @forelse($categories as $category)
                <option value={{ $category->id }} @selected(old('category_id', $product->category_id ?? '') == $category->id)>
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
            {{ old('short_description', $product->short_description ?? '') }}
        </textarea>
    </div>
</div>
<div class="row mt-4">
    <div class='col-8'>
        <label for="editor" class='label-control'>وصف المنتج</label>
        <textarea id='editor' name='long_description' class='form-control mt-2'>
            {{ old('long_description', $product->long_description ?? '') }}
        </textarea>
    </div>
</div>
<div class="mt-4">
    <label class='label-control'>صورة المنتج</label>
    <div class='col-6 mt-2'>
        <div class="file-wrapper form-control">
            <input name="old_image" id="oldImage"
                value="{{ $product->image ?? null }}" hidden />
            <input type='file' name='image' id='productImage' />
        </div>
    </div>
</div>
<div class="mt-4">
    <label class='label-control'>مصغرات المنتج</label>
    <div class='col-6 mt-2'>
        <div class="file-wrapper">
            @php
                
                $thumbnailsImages = null;
                if ($product && $product->images->isNotEmpty()) {
                    $thumbnailsImages = $product->images->map(fn($image) => $image->url)->implode('|');
                }
                
            @endphp
            <input name="old_images" id="oldImage" value="{{ $thumbnailsImages }}"
                hidden />
            <input type='file' name='productImageThumbnails[]' id='productImages'
                multiple />
        </div>
    </div>
</div>

<h5 class="options"
    style="margin-top:1.5rem;padding-top:1rem; border-top: 1px solid #dedede">
    الخيارات
</h5>
<div class="mt-4">
    <label class='label-control'>الالوان</label>
    <div id="selectColorsOtionsWrapper" class="d-flex gap-3 mt-2">
        <input name="color_id" id="variantHiddenInput" hidden
            value="{{ $colorsId }}" />
        @foreach ($colors as $color)
            <div class="product-variant" value="{{ $color->id }}">
                {{ $color->color_name }}
            </div>
        @endforeach
    </div>
    <div class='mt-4'>
        <label class='label-control'>المقاسات</label>
        <div id="selectSizesOptionWrapper" class="d-flex gap-3 mt-2">
            <input name="size_id" id="variantHiddenInput"
                value="{{ $sizesId }}" hidden />
            @foreach ($sizes as $size)
                <div class="product-variant" value="{{ $size->id }}">
                    {{ $size->size_name }}
                </div>
            @endforeach
        </div>
    </div>
</div>


@push('scripts')
    <script type="module">

    $('#editor').summernote({
        placeholder: 'Hello Bootstrap 5',
        tabsize: 2,
        height: 160,
      });

    </script>
@endpush
