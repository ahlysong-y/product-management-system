@extends('layouts.app')

@section('content')
    <div class="card">

        <div class="card-header">
            <h3>Edit Product</h3>
        </div>

        <div class="card-body">

            <form action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Product Image</label>
                    @if ($product->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid"
                                style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Upload a new image to replace the current one</small>
                </div>

                <div class="mb-3">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                </div>

                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="number" name="qty" class="form-control" value="{{ $product->qty }}">
                </div>

                <div class="mb-3">
                    <label>Price</label>
                    <input type="text" name="price" class="form-control" value="{{ $product->price }}">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                </div>

                <button class="btn btn-primary">
                    Update Product
                </button>

            </form>

        </div>

    </div>
@endsection
