@extends('layout')

@section('title', 'Flight Ticket Booking')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg mx-auto" style="max-width: 520px;">
        <div class="card-header bg-warning text-dark text-center">
            <h3 class="mb-0">ระบบจองตั๋วเครื่องบิน</h3>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center mb-4">
                <a href="{{ url('/booking') }}" class="btn btn-warning btn-lg px-4 text-dark">
                    <i class="fas fa-plane-departure mr-2"></i> จองตั๋ว
                </a>
            </div>
            <hr>
            <p class="text-center text-secondary">
                ยินดีต้อนรับสู่ระบบจองตั๋วเครื่องบินออนไลน์
            </p>
        </div>
    </div>
</div>
@endsection
