@extends('layouts.app')

@section('content')
    <h2 class="mb-4">
        Stock History
    </h2>

    <table class="table table-bordered">

        <thead class="table-dark">

            <tr>

                <th>Product</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Date</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($histories as $history)
                <tr>

                    <td>

                        {{ $history->product->name }}

                    </td>

                    <td>

                        {{ $history->type }}

                    </td>

                    <td>

                        {{ $history->qty }}

                    </td>

                    <td>

                        {{ $history->created_at }}

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>
@endsection
