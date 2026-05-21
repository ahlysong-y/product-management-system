<!DOCTYPE html>
<html>

<head>

    <title>Products PDF</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>

</head>

<body>

    <h2>
        Product Report
    </h2>

    <table>

        <thead>

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

</body>

</html>
