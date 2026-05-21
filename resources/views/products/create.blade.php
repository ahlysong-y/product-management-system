@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Add Product</h3>
        </div>

        <div class="card-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/products" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                
                <div class="mb-3">

                    <label>Category</label>

                    <select name="category_id" class="form-control">

                        <option value="">
                            Select Category
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">

                                {{ $category->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="mb-3">
                    <label>Product Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Upload a product image (JPG, PNG, etc.)</small>
                </div>

                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="number" name="qty" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Price</label>
                    <input type="text" name="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <button class="btn btn-success">
                    Save Product
                </button>

            </form>

        </div>
    </div>
@endsection
