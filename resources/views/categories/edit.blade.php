@extends('layout.app')

@section('header-content')
    اضافة قسم
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

    <form class='mainform-app px-3 py-3' method="post" enctype='multipart/form-data'
        action="{{ route('categories.update', ['category' => $category->id]) }}">
        @csrf
        @method('PUT')

        @include('categories.form', ['category' => $category])
    </form>

@endsection
