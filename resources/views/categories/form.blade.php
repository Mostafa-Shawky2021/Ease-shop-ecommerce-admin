@include('partials.validationerrors')
@php
$httpRegex='/https?/';
$categoryImage = '';
if($category) {
    $categoryImage =  preg_match($httpRegex, $category->image)
                ? $category->image
                : asset('storage/'. $category->image) ;
}

   
@endphp
<div>
    <div class="d-flex align-items-center">
        <label class='label-control'>اسم القسم</label>
        <span class='error-message'>*</span>
    </div>
    <div class='col-12 col-sm-9 col-md-7 mt-2'>
        <input type='text' class="form-control" name='cat_name' value="{{ old('cat_name', $category->cat_name ?? '') }}" />
    </div>
</div>
<div class="mt-4">
    <div class='col-6'>
        <label class='label-control'>القسم الرئيسي</label>
    </div>
    <div class='col-12 col-sm-9 col-md-7 mt-2'>
        <select class='form-control mt-2' name='parent_id'>
            <option value=''>...</option>
            @forelse($categories as $cat)
            <option value={{ $cat->id }} @selected(old('parent_id', $category->parent_id ?? '') === $cat->id)>
                {{ $cat->cat_name }}
            </option>
            @empty
            <option disabled>لا يوجد اقسام</option>
            @endforelse
        </select>
    </div>
</div>
<div class="mt-4">
    <label class='label-control'>صورة القسم</label>
    <div class='col-12 col-sm-9 col-md-7 mt-2'>
        <div class="file-wrapper form-control">
            <input name="old_image" id="oldImage"
                value="{{ $categoryImage}}" hidden />
            <input type='file' name='image' id='categoryImage' accept="image/*" />
        </div>
    </div>
</div>
<div class="mt-4">
    <div class="d-flex col-12 col-sm-9 col-md-7 justify-content-between align-items-center">
        <label class='label-control col-3'>صورة خارجية</label>
        <span style="font-size:0.7rem; color:#888">لينك لصورة من مصدر خارجي</span>
    </div>
    <div class="col-12 col-sm-9 col-md-7 mt-2">
        <input type="url" class="form-control" name="image-url" placeholder="https://www.example-image.png.com" />
    </div>
</div>
<div class="mt-4">
    <label class='label-control'>صورة مصغرة</label>
    <div class='col-12 col-sm-9 col-md-7 mt-2'>
        <div class="file-wrapper form-control">
            <input name="old_image_thumbnail" id="oldImage"
                value="{{ $category && $category->image_thumbnail ? asset('storage/' . $category->image_thumbnail) : '' }}"
                hidden />
            <input type='file' name='image_thumbnail' id='thumbnailCategoryImage' accept="image/*" />
        </div>
    </div>
</div>