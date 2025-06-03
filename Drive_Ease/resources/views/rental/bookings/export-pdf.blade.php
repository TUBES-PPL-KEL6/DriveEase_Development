<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bookings Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1a202c;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #4a5568;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f7fafc;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #718096;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bookings Report</h1>
        <p>Generated on {{ now()->format('F j, Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Vehicle</th>
                <th>Customer</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->vehicle->name }}</td>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->start_date }}</td>
                <td>{{ $booking->end_date }}</td>
                <td>Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                <td>{{ ucfirst($booking->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated from DriveEase Rental Management System</p>
        <p>© {{ date('Y') }} DriveEase. All rights reserved.</p>
    </div>
</body>
</html> 