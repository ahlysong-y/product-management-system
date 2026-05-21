<!DOCTYPE html>
<html>

<head>

    <title>Print Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body onload="window.print()">

    <div class="container mt-4">

        <h2 class="mb-4">
            Product Report
        </h2>

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($products as $product)
                    <tr>

                        <td>{{ $product->id }}</td>

                        <td>{{ $product->name }}</td>

                        <td>{{ $product->qty }}</td>

                        <td>${{ $product->price }}</td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</body>

</html>
