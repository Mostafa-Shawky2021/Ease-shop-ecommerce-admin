@extends('layout.app')
@section('content')
    <div class="products-wrapper">
        <header class="inner-content-header">
            <h4 class="title">Products List</h4>
            <a class="btn-add" href="{{ route('products.create') }}"><i
                    class="icon fa fa-plus"></i>Add Product</a>
        </header>

        @if (session()->has('message'))
            <div class="alert alert-{{ session('message')[1] }} alert-dismissible fade show"
                role="alert">
                {{ session('message')[0] }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product name</th>
                        <th>Category name</th>
                        <th>Price</th>
                        <th>Price discount</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Brand</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset("storage/$product->image") }}"
                                        alt='product-image'
                                        class='img-fluid img-thumbnail-small me-2' />
                                @endif
                                <span>{{ $product->product_name }}</span>

                            </td>
                            <td>{{ $product->category->cat_name }}</td>
                            <td>{{ $product->price }}</td>
                            <td style='width: 140px;'>
                                {{ $product->price_discount ? $product->price_discount : 'N/A' }}
                            </td>
                            <td>
                                {{ $product->color ? str_replace(',', '-', $product->color) : 'N/A' }}
                            </td>
                            <td>
                                {{ $product->size ? str_replace(',', '-', $product->size) : 'N/A' }}

                            </td>
                            <td>{{ $product->brand }}</td>

                            <td class="d-flex align-items-center">
                                <a class="edit-link"
                                    href="{{ route('products.edit', ['product' => $product->id]) }}"><i
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
            {{ $products->links('template.pagination') }}
        </div>
    </div>
@endsection
