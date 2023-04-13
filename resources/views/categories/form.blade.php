<div>
    <label class='label-control'>اسم القسم</label>
    <div class='col-6 mt-2'>
        <input type='text' class="form-control" name='cat_name'
            value="{{ old('cat_name', $category->cat_name ?? '') }}" />
    </div>
</div>
<div class="mt-4">
    <div class='col-6'>
        <label class='label-control'>القسم الرئيسي</label>
    </div>
    <div class="col-6">
        <select class='form-control mt-2' name='parent_id'>
            <option value=''>...</option>
            @forelse($categories as $cat)
                <option value={{ $cat->id }} @selected(old('parent_id', $category->parent_id ?? '') === $cat->id)>
                    {{ $cat->cat_name }}
                </option>
            @empty
                <option disabled>Sorry No Categories</option>
            @endforelse
        </select>
    </div>
</div>
<div class="mt-4">
    <label class='label-control'>صورة القسم</label>
    <div class='col-6 mt-2'>
        <div class="file-wrapper form-control">
            <input name="old_image" id="oldImage"
                value="{{ $category->image ?? '' }}" hidden />
            <input type='file' name='image' id='categoryImage' />
        </div>
    </div>
</div>
<div class="mt-4">
    <label class='label-control'>صورة مصغرة</label>
    <div class='col-6 mt-2'>
        <div class="file-wrapper form-control">
            <input name="old_image_thumbnail" id="oldImage"
                value="{{ $category->imageThumbnail->url ?? '' }}" hidden />
            <input type='file' name='image_thumbnail'
                id='thumbnailCategoryImage' />
        </div>
    </div>
</div>
<div class="mt-4 text-end">
    <button class="btn-add">
        اضافة قسم
        <i class="icon fa fa-plus"></i>
    </button>
</div>
