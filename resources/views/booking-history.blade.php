<!DOCTYPE html>
<html lang="th">
<head>
    <title>ประวัติการจอง</title>
    <style>
        body { background: #f9f9f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.08); padding: 32px; }
        h1 { color: #2563eb; margin-bottom: 24px; text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #e0e7ff; text-align: left; }
        th { background: #f3f6fd; color: #2563eb; }
        .btn { display: inline-block; padding: 8px 16px; background: #2563eb; color: #fff; border-radius: 8px; text-align: center; text-decoration: none; }
        .btn:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="container">
        <h1>ประวัติการจอง</h1>
        <table>
            <thead>
                <tr>
                    <th>สายการบิน</th>
                    <th>เที่ยวบิน</th>
                    <th>วันเดินทาง</th>
                    <th>ต้นทาง</th>
                    <th>ปลายทาง</th>
                    <th>ชื่อผู้โดยสาร</th>
                    <th>วันที่จอง</th>
                    <th>ดูตั๋ว</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    @php
                        $flight = json_decode($booking->flight_data, true);
                        $passenger = json_decode($booking->passenger_data, true);
                    @endphp
                    <tr>
                        <td>{{ $flight['airline']['name'] ?? '-' }}</td>
                        <td>{{ $flight['flight']['iata'] ?? '-' }}</td>
                        <td>{{ $flight['flight_date'] ?? '-' }}</td>
                        <td>{{ $flight['departure']['airport'] ?? '-' }}</td>
                        <td>{{ $flight['arrival']['airport'] ?? '-' }}</td>
                        <td>{{ $passenger['full_name'] ?? '-' }}</td>
                        <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('booking.ticket', $booking->id) }}" class="btn" target="_blank">ดูตั๋ว</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>