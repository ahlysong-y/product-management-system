@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="mb-0 fw-bold text-dark" style="font-family: sans-serif;">Products</h1>

        <div class="d-flex gap-2">
            <a href="/products/create" class="btn btn-primary d-inline-flex align-items-center gap-1 shadow-sm px-3 py-2"
                style="border-radius: 8px; font-weight: 600;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Product
            </a>

            <a href="/products/pdf" class="btn btn-danger d-inline-flex align-items-center gap-1 shadow-sm px-3 py-2"
                style="border-radius: 8px; font-weight: 600;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Export PDF
            </a>

            <a href="/products/excel" class="btn btn-success d-inline-flex align-items-center gap-1 shadow-sm px-3 py-2"
                style="border-radius: 8px; font-weight: 600;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125V3.375m1.125 16.5a1.125 1.125 0 001.125 1.125H21m-18.75-1.125V3.375m0 15v-1.5m1.125 1.5h1.5m-.75-11.25h.008v.008H4.5V6.75zm3 0h.008v.008H7.5V6.75zm3 0h.008v.008H10.5V6.75zm3 0h.008v.008H13.5V6.75zm3 0h.008v.008H16.5V6.75zm3 0h.008v.008H19.5V6.75z" />
                </svg>
                Export Excel
            </a>

            <a href="/products/print" target="_blank"
                class="btn btn-secondary d-inline-flex align-items-center gap-1 shadow-sm px-3 py-2"
                style="border-radius: 8px; font-weight: 600;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.72 13.82l-.24-2.122A2.25 2.25 0 018.72 9.22h6.56a2.25 2.25 0 012.24 2.478l-.24 2.122m-10.48 0h10.48m-10.48 0a1.125 1.125 0 00-1.125 1.125V18a2.25 2.25 0 002.25 2.25h10.5A2.25 2.25 0 0019.5 18v-3.06a1.125 1.125 0 00-1.125-1.125m-12 0h12M9 9V4.5A1.5 1.5 0 0110.5 3h3A1.5 1.5 0 0115 4.5V9" />
                </svg>
                Print
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search Form --}}
    <form action="/products" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search Product"
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark" type="submit">
                    Search
                </button>
            </div>
        </div>
    </form>

    {{-- Empty State --}}
    @if ($products->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            <h5>No Products Found</h5>
            <p class="mb-0">{{ request('search') ? 'No products match your search. ' : 'No products added yet. ' }}
                <a href="/products/create">Add your first product</a>
            </p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Actions</th>
                        <th>Category</th>
                        <th>Barcode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>
                                <strong>{{ $key + 1 }}</strong>
                            </td>
                            <td style="width: 80px;">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px; border-radius: 4px;">
                                        <span class="text-muted small">No Image</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                            </td>
                            <td>
                                <small>{{ $product->description ? Str::limit($product->description, 50) : '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->qty < 10 ? 'warning' : 'success' }}">
                                    {{ $product->qty }} units
                                </span>
                            </td>
                            <td>
                                <strong>${{ number_format($product->price, 2) }}</strong>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="/products/{{ $product->id }}" class="btn btn-info btn-sm" title="View">
                                        👁️
                                    </a>
                                    <a href="/products/{{ $product->id }}/edit" class="btn btn-warning btn-sm"
                                        title="Edit">
                                        ✏️
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $product->id }}"
                                        title="Delete">
                                        🗑️
                                    </button>
                                </div>
                            </td>
                            <td>

                                {{ $product->category->name ?? 'No Category' }}

                            </td>
                            <td>
                                {{ $product->barcode }}
                                {!! DNS1D::getBarcodeHTML($product->barcode, 'C128') !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">

                {{ $products->links() }}

            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This product will be deleted permanently!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create and submit form
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/products/${productId}`;

                        const csrfToken = document.querySelector('meta[name="csrf-token"]')
                            ?.getAttribute('content');
                        if (csrfToken) {
                            const tokenInput = document.createElement('input');
                            tokenInput.type = 'hidden';
                            tokenInput.name = '_token';
                            tokenInput.value = csrfToken;
                            form.appendChild(tokenInput);
                        }

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
