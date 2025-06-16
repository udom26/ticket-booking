@extends('layout')

@section('title', 'ผลการค้นหาเที่ยวบิน')

@section('content')

<style>
    body {
        background: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #3e3e3e;
        margin: 0;
    }

    .outer-container {
        max-width: 700px;
        margin: 50px auto 80px auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border: 1.5px solid #ddd;
        padding: 30px 36px;
    }

    h1 {
        font-size: 1.9em;
        font-weight: 700;
        color: #3e3e3e;
        text-align: center;
        margin-bottom: 32px;
    }

    .flight-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        padding: 18px 24px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        transition: box-shadow 0.3s ease;
        border: 1.2px solid #ddd;
    }

    .flight-card:hover {
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.12);
    }

    .airline-section {
        flex: 1 1 25%;
    }

    .airline-name {
        font-size: 1.15em;
        font-weight: 700;
        color: #ffc107; /* สีเหลืองทอง */
        margin-bottom: 6px;
    }

    .flight-info-small {
        font-size: 0.85em;
        color: #6c757d;
    }

    .flight-times {
        flex: 1 1 40%;
        text-align: center;
        color: #3e3e3e;
    }

    .flight-times .time {
        font-size: 1.4em;
        font-weight: 700;
    }

    .flight-times .duration {
        font-size: 0.9em;
        color: #6c757d;
        margin: 6px 0;
    }

    .flight-locations {
        font-size: 1em;
        color: #3e3e3e;
        font-weight: 600;
        letter-spacing: 0.03em;
    }

    .price-section {
        flex: 1 1 25%;
        text-align: right;
    }

    .flight-price {
        color: #ffc107;
        font-size: 1.2em;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .select-btn {
        background: #ffc107;
        color: #3e3e3e;
        border: none;
        border-radius: 6px;
        padding: 10px 24px;
        font-weight: 700;
        font-size: 1em;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(255, 193, 7, 0.4);
        transition: background 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .select-btn:hover {
        background: #e0a800;
    }

    .back-btn {
        display: block;
        margin: 40px auto 0 auto;
        background: #ffc107;
        color: #3e3e3e;
        padding: 14px 32px;
        border-radius: 8px;
        text-align: center;
        width: fit-content;
        font-weight: 700;
        font-size: 1.1em;
        text-decoration: none;
        box-shadow: 0 6px 18px rgba(255, 193, 7, 0.45);
        transition: background 0.3s ease;
    }

    .back-btn:hover {
        background: #e0a800;
    }

    @media (max-width: 900px) {
        .outer-container {
            margin: 20px 12px 60px 12px;
            padding: 24px 20px;
        }

        .flight-card {
            flex-direction: column;
            text-align: center;
        }

        .airline-section, .flight-times, .price-section {
            flex: 1 1 100%;
        }

        .price-section {
            margin-top: 12px;
        }
    }
</style>

<div class="outer-container">
    <h1>เที่ยวบินทั้งหมด</h1>

    @if(count($results))
        @foreach($results as $flight)
            <div class="flight-card">
                <div class="airline-section">
                    <div class="airline-name">{{ $flight['airline']['name'] ?? '-' }}</div>
                    <div class="flight-info-small">เที่ยวบิน {{ $flight['flight']['iata'] ?? '-' }}</div>
                </div>

                <div class="flight-times">
                    <div class="time">
                        {{ $flight['departure']['scheduled'] ? date('H:i', strtotime($flight['departure']['scheduled'])) : '-' }} - 
                        {{ $flight['arrival']['scheduled'] ? date('H:i', strtotime($flight['arrival']['scheduled'])) : '-' }}
                    </div>
                    <div class="duration">
                        {{ $flight['flight_date'] ?? '-' }}
                    </div>
                    <div class="flight-locations">
                        {{ $flight['departure']['iata'] ?? '-' }} → {{ $flight['arrival']['iata'] ?? '-' }}
                    </div>
                </div>

                <div class="price-section">
                    <form action="{{ route('booking-details') }}" method="get">
                        <input type="hidden" name="flight" value="{{ base64_encode(json_encode($flight)) }}">
                        <button type="submit">จอง</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p style="text-align:center; color:#888;">ไม่พบเที่ยวบินที่ตรงกับเงื่อนไข</p>
    @endif

    <a href="{{ url('/booking') }}" class="back-btn">กลับหน้าค้นหา</a>
</div>

@endsection
