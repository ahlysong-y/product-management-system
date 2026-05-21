@extends('layouts.app')

@section('content')
    <div class="card">

        <div class="card-header">
            <h3>Create Sale</h3>
        </div>

        <div class="card-body">

            <form action="/sales" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Product</label>

                    <select name="product_id" class="form-control">

                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">

                                {{ $product->name }}
                                (${{ $product->price }})
                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Quantity</label>

                    <input type="number" name="qty" class="form-control">

                </div>

                <button class="btn btn-success">
                    Complete Sale
                </button>

            </form>

        </div>

    </div>
@endsection
