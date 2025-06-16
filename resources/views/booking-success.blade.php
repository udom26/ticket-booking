@extends('layout')

@section('title', 'การจองสำเร็จ')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card text-center shadow-lg">
        <div class="card-body">
            <h2 class="text-success">✅ การจองสำเร็จ</h2>
            <p class="mt-3 mb-4">ขอบคุณสำหรับการจองเที่ยวบิน</p>

            <h5 class="mb-3">รหัสการจอง: <strong>{{ $booking->booking_code }}</strong></h5>
            <p>ชื่อผู้โดยสาร: {{ $booking->fullname }}</p>
            <p>เที่ยวบิน: {{ $booking->flight_id }}</p>

            <p class="mt-4">
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">กลับหน้าหลัก</a>
            </p>
        </div>
    </div>
</div>
@endsection
