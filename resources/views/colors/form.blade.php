@php

$colorValue = $color ? $color->color_name . ',' . $color->color_value : null;
@endphp
<div>
    <label class="label-control">اسم اللون</label>
    <div class="mt-3">
        <input type="text" class="form-control" id="variantInput" value="{{ $color->color_name ?? '' }}" />
        <input type="text" id="variantHiddenInput" name="colors_name" value="{{ old('color_name', $colorValue ?? '') }}" hidden />
    </div>
</div>
<div class="mt-3 color-picker-wrapper">
    <label class="label-control">قيمة اللون</label>
    <div class="mt-3">
        <input type="text" class="color-picker" />
    </div>
</div>