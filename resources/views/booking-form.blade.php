@extends('layout')

@section('title', 'กรอกข้อมูลผู้โดยสาร')

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">กรอกข้อมูลผู้โดยสาร</h2>

    <div class="card shadow">
        <div class="card-body">
            <h5 class="mb-3">
                เที่ยวบิน {{ $flight['flight']['iata'] ?? '-' }}: 
                {{ $flight['departure']['iata'] ?? '?' }} → {{ $flight['arrival']['iata'] ?? '?' }}
            </h5>

            <form action="{{ route('booking.confirm') }}" method="POST">
                @csrf
                <input type="hidden" name="flight_index" value="{{ $index }}">

                <div class="form-group">
                    <label for="fullname">ชื่อ - นามสกุล</label>
                    <input type="text" name="fullname" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="identity_number">หมายเลขบัตรประชาชน / Passport</label>
                    <input type="text" name="identity_number" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone">เบอร์โทรศัพท์</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">อีเมล</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-warning">ยืนยันการจอง</button>
                <a href="{{ url('/search-flights') }}" class="btn btn-secondary ml-2">ย้อนกลับ</a>
            </form>
        </div>
    </div>
</div>
@endsection
