<div class="col-8">
    <label for="aboutus" class='label-control'>من نحن</label>
    <textarea name="aboutus" class="form-control mt-2" style="min-height:120px"
        id="aboutus">
        {{ old('aboutus', $footer->aboutus ?? '') }}
    </textarea>
</div>
<p
    style="font-size:0.8rem; color:#828282; font-weight:600 border-top:1px solid #dedede; margin-top:2rem; padding-top:10px">
    سوشيال</p>
<div class="col-8 mt-3">
    <label for="address" class='label-control'>العنوان</label>
    <input type="text" id="address" class="form-control mt-2" name="address"
        value="{{ old('address', $footer->address ?? '') }}" />
</div>
<div class="col-8 mt-3">
    <label for="phone" class='label-control'>رقم التلفون</label>
    <input type="text" id="phone" class="form-control mt-2" name="phone"
        value="{{ old('phone', $footer->phone ?? '') }}" />
</div>
<div class="col-8 mt-3">
    <label for="phone" class='label-control'>رقم الواتس</label>
    <input type="text" id="phone" class="form-control mt-2" name="whatsapp_number"
        value="{{ old('whatsapp_number', $footer->whatsapp_number ?? '') }}" />
</div>
<div class="col-8 mt-3">
    <label for="facebook" class='label-control'>facebook</label>
    <input type="text" id="facebook" class="form-control mt-2" name="facebook_link"
        value="{{ old('facebook_link', $footer->facebook_link ?? '') }}" />
</div>
<div class="col-8 mt-3">
    <label for="facebook" class='label-control'>gmail</label>
    <input type="text" id="facebook" class="form-control mt-2" name="gmail_link"
        value="{{ old('gmail_link', $footer->gmail_link ?? '') }}" />
</div>
<div class="col-8 mt-3">
    <label for="twitter" class='label-control'>twitter</label>
    <input type="text" id="twitter" class="form-control mt-2" name="twitter_link"
        value="{{ old('twitter_link', $footer->twitter_link ?? '') }}" />
</div>