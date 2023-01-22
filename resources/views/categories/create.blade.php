@extends('layout.app')
@section('content')
       
<div class="category-add-wrapper">
    <header class="inner-content-header">
        <h4 class="title">New Category</h4>
    </header>

    @if(!empty($errors->all()))
    <ul class='list-unstyled'>
        @foreach($errors->all() as $error) 
        <li class='alert alert-warning'>{{$error}}</li>
        @endforeach
    </ul>
    @endif

    <form class='category-add-form' enctype='multipart/form-data' method="post" action="{{route('categories.store')}}">
        @csrf
        <div class='row align-items-center'>
            <div class='col-12 col-sm-2'>
                <label class='label-control'>Category name</label>
            </div>
            <div class='col-12 col-sm-10'>
                <input type='text' class="form-control" placeholder="Enter category name" name='categoryName'/>
            </div>
        </div>
        <div class="mt-4 row align-items-center">
            <div class='col-12 col-sm-2'>
                <label for="description" class='label-control'>Description</label>
            </div>
            <div class="col-12 col-sm-10">
                <textarea  id='description' name='description' class='form-control'></textarea>
            </div>
        </div>
        <div class="mt-4 row align-items-center">
            <div class='col-12 col-sm-2'>
                <label class='label-control'>Parent category</label>
            </div>
            <div class="col-12 col-sm-10">
                <select class='form-control' name='categoryParent'>
                    <option value=''>...</option>
                    @forelse($categories as $category) 
                        <option value={{$category->id}}>{{$category->cat_name}}</option>
                    @empty
                        <option disabled>Sorry No Categories</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="mt-4 row align-items-center">
            <div class='col-12 col-sm-2'>
                <label for="image-category" class='label-control'>Image Category</label>
            </div>
            <div class='col-12 col-sm-10'>
                <input id="image-category" type='file' name='categoryImage'/>
            </div>
        </div> 
        <div class="mt-4 text-end">
            <button class="btn-add"><i class="icon fa fa-plus"></i>Add User</button>
        </div>
       
    </form>
</div>


@endsection