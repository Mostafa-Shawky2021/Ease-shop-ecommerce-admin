@extends('layout.app')
@section('content')
    <div class="categories-wrapper">
        <header class="inner-content-header">
            <h4 class="title">Categories List</h4>
            <a class="btn-add" href="{{ route('categories.create') }}"><i
                    class="icon fa fa-plus"></i>Add Category</a>
        </header>

        @if (session()->has('message'))
            <div class="alert alert-{{ session('message')[1] }}">
                {{ session('message')[0] }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category Name</th>
                        <th>Parent Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $category->cat_name }}</td>
                            <td>
                                @if ($category->parent_id)
                                    {{ $category->parentCategory->cat_name }}
                                @else
                                    no parent category
                                @endif
                            </td>

                            <td class="d-flex align-items-center">
                                <a class="edit-link" href="#"><i
                                        class="icon icon-edit fa fa-edit"></i></a>
                                <form>
                                    <button
                                        onclick="return confirm('Are you sure you want to delete that user')"
                                        class="btn-delete" type="submit"><i
                                            class="icon icon-delete fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $categories->links('template.pagination') }}
        </div>
    </div>
@endsection
