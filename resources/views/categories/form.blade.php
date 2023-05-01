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
                <option disabled>لا يوجد اقسام</option>
            @endforelse
        </select>
    </div>
</div>
<div class="mt-4">
    <label class='label-control'>صورة القسم</label>
    <div class='col-6 mt-2'>
        <div class="file-wrapper form-control">
            <input name="old_image" id="oldImage"s
                value="{{ $category && $category->image ? asset('storage/' . $category->image) : '' }}"
                hidden />
            <input type='file' name='image' id='categoryImage' />
        </div>
    </div>
</div>
<div class="mt-4">
    <label class='label-control'>صورة مصغرة</label>
    <div class='col-6 mt-2'>
        <div class="file-wrapper form-control">
            <input name="old_image_thumbnail" id="oldImage"
                value="{{ $category && $category->image_thumbnail ? asset('storage/' . $category->image_thumbnail) : '' }}"
                hidden />
            <input type='file' name='image_thumbnail'
                id='thumbnailCategoryImage' />
        </div>
    </div>
</div>
<div class="mt-4">
    <label class='label-control' for="is_special">حالة القسم</label>
    <div class='col-6 mt-2'>
        <select class="form-control" name="is_special" id="is_special"
            style="font-size:0.8rem">
            <option value="0">عادي</option>
            <option value="1">مميز</option>
        </select>
    </div>
</div>
<div class="mt-4">
    <label class='label-control'>صورة مميزة للقسم</label>
    <div class='col-6 mt-2'>
        <div class="file-wrapper form-control">
            <input name="old_image_topcategory" id="oldImage"
                value="{{ $category && $category->image_topcategory ? asset('storage/' . $category->image_topcategory) : '' }}"
                hidden />
            <input type='file' name='image_topcategory'
                id='topCategoryImageFile' />
        </div>
    </div>
</div>
