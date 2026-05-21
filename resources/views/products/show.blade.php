@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $product->name }}</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 300px; border-radius: 8px;">
                                    <span class="text-muted">No Image Available</span>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Price:</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Quantity in Stock:</td>
                                    <td>
                                        <span class="badge bg-{{ $product->qty < 10 ? 'warning' : 'success' }}">
                                            {{ $product->qty }} units
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Created:</td>
                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Updated:</td>
                                    <td>{{ $product->updated_at->format('M d, Y') }}</td>
                                </tr>
                            </table>

                            <div class="mt-4">
                                <h5>Description</h5>
                                <p>{{ $product->description ?? 'No description provided.' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="/products/{{ $product->id }}/edit" class="btn btn-warning">
                            Edit Product
                        </a>
                        <a href="/products" class="btn btn-secondary">
                            Back to Products
                        </a>
                        <form action="/products/{{ $product->id }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
