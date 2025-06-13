@extends('layout')

@section('title', 'ผลการค้นหาเที่ยวบิน')

@section('content')
    <style>
        .container {
            max-width: 860px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h1 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 32px;
        }

        .flight-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.08);
            padding: 24px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .airline-section {
            flex: 1 1 25%;
        }

        .airline-name {
            font-size: 18px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .flight-times {
            flex: 1 1 40%;
            text-align: center;
            color: #111827;
        }

        .flight-times .time {
            font-size: 20px;
            font-weight: bold;
        }

        .flight-times .duration {
            font-size: 12px;
            color: #6b7280;
            margin: 4px 0;
        }

        .flight-locations {
            font-size: 14px;
            color: #4b5563;
        }

        .price-section {
            flex: 1 1 25%;
            text-align: right;
        }

        .flight-price {
            color: #ef4444;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .select-btn {
            background: #2563eb;
            color: #fff;
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .select-btn:hover {
            background: #1e40af;
        }

        .back-btn {
            display: block;
            margin: 40px auto;
            background: #2563eb;
            color: #fff;
            padding: 10px 24px;
            border-radius: 8px;
            text-align: center;
            width: fit-content;
            text-decoration: none;
            font-weight: bold;
        }

        .back-btn:hover {
            background: #1e40af;
        }
    </style>

    <h1>เที่ยวบินทั้งหมด</h1>

    @if(count($results))
        @foreach($results as $flight)
            <div class="flight-card">
                <div class="airline-section">
                    <div class="airline-name">{{ $flight['airline']['name'] ?? '-' }}</div>
                    <div style="font-size: 12px; color: #6b7280;">เที่ยวบิน {{ $flight['flight']['iata'] ?? '-' }}</div>
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
                    <a href="#" class="select-btn">เลือก</a>
                </div>
            </div>
        @endforeach
    @else
        <p style="text-align:center; color:#888;">ไม่พบเที่ยวบินที่ตรงกับเงื่อนไข</p>
    @endif

    <a href="{{ url('/booking') }}" class="back-btn">กลับหน้าค้นหา</a>
@endsection
