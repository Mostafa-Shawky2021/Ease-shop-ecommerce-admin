<div class="col-8">
    <label for="editor" class='label-control'>المحتوي</label>
    <textarea id='editor' name='content' class='form-control mt-2'>
        {{ old('content', $carousel->content ?? '') }}
    </textarea>
</div>
<div class="col-8 mt-3">
    <label for="price" class='label-control'>وقت السليدر</label>
    <input type="text" class="form-control mt-2" name="carousel_time"
        value="{{ old('carousel_time', $carousel->carousel_time ?? '') }}" />
</div>
<div class="col-8 mt-3">
    <label for="price" class='label-control '>اضافة صور</label>
    <div class="file-wrapper form-control mt-2">
        @php
            $carouselImages = null;
            // convert image pathes into string with | sperator so image upload plugin  can handle images
            if ($carousel && $carousel->images->isNotEmpty()) {
                $carouselImages = $carousel->images->map(fn($image) => $image->url)->implode('|');
            }
            
        @endphp
        <input name="old_image" id="oldImage" hidden
            value="{{ $carouselImages }}" />
        <input type='file' name='images[]' id='sliderImages' multiple />
    </div>
</div>
