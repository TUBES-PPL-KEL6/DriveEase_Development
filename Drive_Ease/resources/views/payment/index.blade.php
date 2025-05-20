<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <!-- You can include Bootstrap or any CSS framework if you want -->
</head>
<body>
    <h1>Payment History</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Car</th>
                <th>Price</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paymentHistories as $history)
                <tr>
                    <td>{{ $history->id }}</td>
                    <td>{{ $history->username }}</td>
                    <td>{{ $history->car }}</td>
                    <td>{{ $history->price }}</td>
                    <td>{{ $history->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
