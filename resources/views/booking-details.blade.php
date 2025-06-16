{{-- filepath: c:\xampp\htdocs\ticket-booking\resources\views\booking-details.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <title>จองตั๋ว</title>
    <style>
        body {
            background: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 32px;
        }
        h1 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 24px;
        }
        .flight-details, .passenger-form {
            margin-bottom: 24px;
        }
        .flight-details h2, .passenger-form h2 {
            color: #1e40af;
            margin-bottom: 16px;
        }
        .flight-details p {
            margin: 8px 0;
            font-size: 1em;
            color: #333;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #1e40af;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1.5px solid #2563eb;
            border-radius: 8px;
            font-size: 1em;
            outline: none;
            background: #f3f6fd;
        }
        .form-group input:focus {
            border-color: #1e40af;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
        }
        .submit-btn:hover {
            background: #1a365d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>จองตั๋ว</h1>

        <!-- รายละเอียดเที่ยวบิน -->
        <div class="flight-details">
            <h2>รายละเอียดเที่ยวบิน</h2>
            <p><strong>สายการบิน:</strong> {{ $flight['airline']['name'] ?? '-' }}</p>
            <p><strong>หมายเลขเที่ยวบิน:</strong> {{ $flight['flight']['iata'] ?? '-' }}</p>
            <p><strong>วันและเวลาเดินทาง:</strong> {{ $flight['flight_date'] ?? '-' }} เวลา {{ isset($flight['departure']['scheduled']) ? date('H:i', strtotime($flight['departure']['scheduled'])) : '-' }}</p>
            <p><strong>ต้นทาง:</strong> {{ $flight['departure']['airport'] ?? '-' }} ({{ $flight['departure']['iata'] ?? '-' }})</p>
            <p><strong>ปลายทาง:</strong> {{ $flight['arrival']['airport'] ?? '-' }} ({{ $flight['arrival']['iata'] ?? '-' }})</p>
            <p><strong>ระยะเวลาเดินทาง:</strong> {{ isset($flight['departure']['scheduled']) && isset($flight['arrival']['scheduled']) ? gmdate('H:i', strtotime($flight['arrival']['scheduled']) - strtotime($flight['departure']['scheduled'])) : '-' }}</p>
        </div>

        <!-- ฟอร์มกรอกข้อมูลผู้โดยสาร -->
        <div class="passenger-form">
            <h2>ข้อมูลผู้โดยสาร</h2>
            <form action="{{ url('/confirm-booking') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="full_name">ชื่อ-นามสกุล</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="phone">หมายเลขโทรศัพท์</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="email">อีเมล</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="submit" class="submit-btn">ยืนยันการจอง</button>
            </form>
        </div>
    </div>
</body>
</html>