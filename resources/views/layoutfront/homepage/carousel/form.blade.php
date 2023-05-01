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
