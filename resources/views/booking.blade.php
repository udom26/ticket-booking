@extends('layout')

@section('title', 'ค้นหาเที่ยวบิน')

@section('content')
    <style>
        body {
            background: #e3f0ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1a365d;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            min-width: 350px;
            margin: 40px auto;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 32px 0 rgba(30, 64, 175, 0.10);
            padding: 36px 40px 32px 40px;
        }

        h1 {
            color: #2563eb;
            text-align: center;
            margin-bottom: 24px;
            font-size: 2.2em;
            font-weight: bold;
        }

        .search-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .swap-row {
            display: flex;
            align-items: flex-end;
            gap: 24px;
            width: 100%;
        }

        .center-row {
            justify-content: center;
        }

        .search-group {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .date-group {
            max-width: 300px;
            width: 100%;
        }

        .search-label {
            font-size: 1em;
            margin-bottom: 6px;
            color: #1e40af;
            font-weight: bold;
        }

        .search-input, .search-select {
            width: 100%;
            min-width: 0;
            padding: 12px 14px;
            border: 1.5px solid #2563eb;
            border-radius: 8px;
            font-size: 1.08em;
            outline: none;
            background: #f3f6fd;
            box-sizing: border-box;
        }

        .search-input:focus, .search-select:focus {
            border: 1.5px solid #1e40af;
        }

        .swap-btn {
            background: #e0e7ff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 24px;
        }

        .swap-btn:hover {
            background: #2563eb;
            color: #fff;
        }

        .search-btn {
            background: #189eff;
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 18px 0;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            margin-top: 24px;
            transition: background 0.2s;
            width: 100%;
        }

        .search-btn:hover {
            background: #2563eb;
        }

        @media (max-width: 900px) {
            .container { max-width: 98vw; padding: 18px 4vw; }
            .swap-row { flex-direction: column; gap: 12px; align-items: stretch; }
        }
    </style>

    <div class="container">
        <h1>ค้นหาเที่ยวบิน</h1>
        <form class="search-container" action="{{ url('/search-flights') }}" method="get">
            <div class="swap-row">
                <div class="search-group" style="flex:1;">
                    <span class="search-label">จาก</span>
                    <div style="display:flex;align-items:center;">
                        <span style="font-size:1.2em;">🛫</span>
                        <select class="search-select" name="departure" id="departure" required style="margin-left:8px;">
                            <option value="">เลือกสนามบินต้นทาง</option>
                            @php
                                $departures = [];
                                $allRoutes = [];
                                if(isset($flights['data'])) {
                                    foreach($flights['data'] as $flight) {
                                        $dep = $flight['departure']['airport'] ?? null;
                                        $depCode = $flight['departure']['iata'] ?? '';
                                        $depCity = $flight['departure']['city'] ?? '';
                                        $depCountry = $flight['departure']['country'] ?? '';
                                        $arr = $flight['arrival']['airport'] ?? null;
                                        $arrCode = $flight['arrival']['iata'] ?? '';
                                        $arrCity = $flight['arrival']['city'] ?? '';
                                        $arrCountry = $flight['arrival']['country'] ?? '';
                                        $depKey = $depCode . '|' . $dep;
                                        $arrKey = $arrCode . '|' . $arr;
                                        if($dep && !isset($departures[$depKey])) {
                                            $departures[$depKey] = [
                                                'name' => $dep,
                                                'code' => $depCode,
                                                'city' => $depCity,
                                                'country' => $depCountry
                                            ];
                                        }
                                        if($depCode && $arrCode) {
                                            $allRoutes[$depCode][] = [
                                                'name' => $arr,
                                                'code' => $arrCode,
                                                'city' => $arrCity,
                                                'country' => $arrCountry
                                            ];
                                        }
                                    }
                                }
                            @endphp
                            @foreach($departures as $dep)
                                <option value="{{ $dep['code'] }}">
                                    {{ $dep['city'] ? $dep['city'].' ' : '' }}{{ $dep['name'] }}{{ $dep['code'] ? ' ('.$dep['code'].')' : '' }}{{ $dep['country'] ? ' - '.$dep['country'] : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="button" class="swap-btn" onclick="swapAirports()" title="สลับสนามบิน">
                    🔄
                </button>

                <div class="search-group" style="flex:1;">
                    <span class="search-label">ถึง</span>
                    <div style="display:flex;align-items:center;">
                        <span style="font-size:1.2em;">🛬</span>
                        <select class="search-select" name="arrival" id="arrival" required style="margin-left:8px;">
                            <option value="">เลือกสนามบินปลายทาง</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="swap-row center-row">
                <div class="search-group date-group">
                    <span class="search-label">วันออกเดินทาง</span>
                    <input class="search-input" type="date" name="depart_date" required>
                </div>
            </div>

            <button class="search-btn" type="submit">ค้นหาเที่ยวบิน</button>
        </form>
    </div>

    <script>
        function swapAirports() {
            const dep = document.getElementById('departure');
            const arr = document.getElementById('arrival');
            const temp = dep.value;
            dep.value = arr.value;
            arr.value = temp;
        }

        const allRoutes = @json($allRoutes);

        document.getElementById('departure').addEventListener('change', function() {
            const depCode = this.value;
            const arrivalSelect = document.getElementById('arrival');
            arrivalSelect.innerHTML = '<option value="">เลือกสนามบินปลายทาง</option>';
            if(depCode && allRoutes[depCode]) {
                const seen = new Set();
                allRoutes[depCode].forEach(arr => {
                    if(arr.code && !seen.has(arr.code)) {
                        seen.add(arr.code);
                        let label = (arr.city ? arr.city + ' ' : '') + arr.name;
                        if(arr.code) label += ' (' + arr.code + ')';
                        if(arr.country) label += ' - ' + arr.country;
                        arrivalSelect.innerHTML += `<option value="${arr.code}">${label}</option>`;
                    }
                });
            }
        });
    </script>
@endsection
