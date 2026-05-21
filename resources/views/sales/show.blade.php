<!DOCTYPE html>
<html>

<head>

    <title>Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-dark text-white">

                <h3>
                    Sales Invoice
                </h3>

            </div>

            <div class="card-body">

                <h5>
                    Invoice ID:
                    #{{ $sale->id }}
                </h5>

                <hr>

                <p>

                    <strong>Product:</strong>

                    {{ $sale->product->name }}

                </p>

                <p>

                    <strong>Quantity:</strong>

                    {{ $sale->qty }}

                </p>

                <p>

                    <strong>Unit Price:</strong>

                    ${{ $sale->product->price }}

                </p>

                <p>

                    <strong>Total:</strong>

                    ${{ $sale->total }}

                </p>

                <p>

                    <strong>Date:</strong>

                    {{ $sale->created_at }}

                </p>

                <button onclick="window.print()" class="btn btn-primary">

                    Print Invoice

                </button>

            </div>

        </div>

    </div>

</body>

</html>
