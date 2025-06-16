{{-- filepath: c:\xampp\htdocs\ticket-booking\resources\views\booking-confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
    <title>ยืนยันการจอง</title>
    <style>
        body { background: #f9f9f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { max-width: 500px; margin: 60px auto; background: #fff; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.08); padding: 32px; text-align: center; }
        h1 { color: #2563eb; margin-bottom: 18px; }
        .success { color: #16a34a; font-size: 1.2em; margin-bottom: 18px; }
        .info { color: #333; margin-bottom: 10px; }
        .btn { display: inline-block; margin-top: 24px; background: #2563eb; color: #fff; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: bold; }
        .btn:hover { background: #1e40af; }
    </style>
</head>
<body>
    <div class="container">
        <h1>ยืนยันการจอง</h1>
        <div class="success">🎉 การจองของคุณเสร็จสมบูรณ์แล้ว!</div>
        @if(session('booking_id'))
            <div class="info">หมายเลขการจอง: <strong>{{ session('booking_id') }}</strong></div>
        @endif
        <div class="info">ขอบคุณที่ใช้บริการของเรา</div>
        <a href="{{ url('/') }}" class="btn">กลับหน้าหลัก</a>
    </div>
</body>
</html>
