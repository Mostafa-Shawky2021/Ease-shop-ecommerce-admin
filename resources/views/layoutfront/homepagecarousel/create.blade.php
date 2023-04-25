@extends('layout.app')

@section('header-content')
    اضافة محتوي السليدر
@endsection

@section('content')
    @if (!empty($errors->all()))
        <ul class='list-unstyled'>
            @foreach ($errors->all() as $error)
                <li class='alert alert-warning'>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    @endif
    <form class='mainform-app px-3 py-3' style="margin-top:1rem;"
        enctype='multipart/form-data' method="post"
        action="{{ route('layout.homepage.carousel.store') }}">
        @csrf
        @include('layoutfront.homepagecarousel.form', [
            'carousel' => null,
        ])
        <div class="mt-4 text-end">
            <button class="btn-add">
                اضافة المحتوي
                <i class="icon fa fa-plus"></i>
            </button>
        </div>
    </form>
@endsection


@push('scripts')
    <script type="module">

    $('#editor').summernote({
        placeholder: 'Hello Bootstrap 5',
        tabsize: 2,
        height: 160,
      });

    </script>
@endpush
