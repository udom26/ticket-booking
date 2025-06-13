@extends('layout')

@section('title', 'Flight Ticket Booking')

@section('content')
<style>
    .home-container {
        max-width: 520px;
        margin: 60px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 32px 0 rgba(30, 64, 175, 0.10);
        padding: 32px 36px 28px 36px;
    }
    h1 {
        color: #2563eb;
        text-align: center;
        margin-bottom: 18px;
    }
    nav {
        display: flex;
        justify-content: center;
        gap: 18px;
        margin-bottom: 24px;
    }
    nav a {
        background: #2563eb;
        color: #fff;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.2s;
    }
    nav a:hover {
        background: #1e40af;
    }
    hr {
        border: none;
        border-top: 2px solid #2563eb;
        margin: 18px 0;
    }
    p {
        text-align: center;
        font-size: 1.1em;
    }
</style>

<div class="home-container">
    <h1>ระบบจองตั๋วเครื่องบิน</h1>
    <nav>
        <a href="{{ url('/booking') }}">จองตั๋ว</a>
    </nav>
    <hr>
    <p>ยินดีต้อนรับสู่ระบบจองตั๋วเครื่องบินออนไลน์</p>
</div>
@endsection
