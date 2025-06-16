<!DOCTYPE html>
<html lang="th">
<head>
    <title>ตั๋วโดยสาร</title>
    <style>
        body { background: #f9f9f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .ticket-container { max-width: 480px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.08); padding: 32px; }
        h2 { color: #2563eb; text-align: center; margin-bottom: 24px; }
        .info { margin-bottom: 10px; }
        .label { color: #1e40af; font-weight: bold; }
        .barcode { text-align: center; margin-top: 24px; }
    </style>
</head>
<body>
    <div class="ticket-container">
        <h2>ตั๋วโดยสาร</h2>
        <div class="info"><span class="label">ชื่อผู้โดยสาร:</span> {{ $passenger['full_name'] ?? '-' }}</div>
        <div class="info"><span class="label">สายการบิน:</span> {{ $flight['airline']['name'] ?? '-' }}</div>
        <div class="info"><span class="label">เที่ยวบิน:</span> {{ $flight['flight']['iata'] ?? '-' }}</div>
        <div class="info"><span class="label">วันเดินทาง:</span> {{ $flight['flight_date'] ?? '-' }}</div>
        <div class="info"><span class="label">ต้นทาง:</span> {{ $flight['departure']['airport'] ?? '-' }} ({{ $flight['departure']['iata'] ?? '-' }})</div>
        <div class="info"><span class="label">ปลายทาง:</span> {{ $flight['arrival']['airport'] ?? '-' }} ({{ $flight['arrival']['iata'] ?? '-' }})</div>
        <div class="info"><span class="label">เวลาออกเดินทาง:</span> {{ isset($flight['departure']['scheduled']) ? date('H:i', strtotime($flight['departure']['scheduled'])) : '-' }}</div>
        <div class="info"><span class="label">เวลาถึง:</span> {{ isset($flight['arrival']['scheduled']) ? date('H:i', strtotime($flight['arrival']['scheduled'])) : '-' }}</div>
        <div class="info"><span class="label">วันที่จอง:</span> {{ $booking->created_at->format('d/m/Y H:i') }}</div>
        <div class="barcode">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ $booking->id }}" alt="QR Code">
            <div style="font-size:0.9em;color:#888;">Booking ID: {{ $booking->id }}</div>
        </div>
    </div>
</body>
</html>