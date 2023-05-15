@if(session()->has('message'))
<div class="alert alert-{{session('message')[1]}} alert-dismissible fade show" role="alert" style="">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <span style="font-size:0.83rem">{{session('message')[0]}}</span>
</div>
@endif