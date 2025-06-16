@extends('layout')

@section('title', 'ค้นหาเที่ยวบิน')

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
        margin: 50px auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border: 1.5px solid #ddd;
    }

    .header {
        background-color: #ffc107;
        padding: 16px 0;
        text-align: center;
        font-size: 1.8em;
        font-weight: 700;
        color: #3e3e3e;
        border-bottom: 1.5px solid #e0a800;
    }

    .container {
        padding: 40px 48px;
        background: #fff;
    }

    .search-container {
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .swap-row {
        display: flex;
        align-items: flex-end;
        gap: 28px;
    }

    .search-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .search-label {
        font-size: 1em;
        margin-bottom: 8px;
        color: #6c757d;
        font-weight: 600;
        text-align: center;
    }

    .search-input, .search-select {
        width: 100%;
        padding: 14px 16px;
        border: 1.8px solid #ced4da;
        border-radius: 4px;
        font-size: 1.1em;
        font-weight: 600;
        background: #fff;
        color: #3e3e3e;
        transition: border-color 0.3s, background 0.3s;
        box-sizing: border-box;
    }

    .search-input:focus, .search-select:focus {
        border-color: #ffc107;
        background: #fff9db;
        box-shadow: 0 0 8px rgba(255, 193, 7, 0.5);
        outline: none;
    }

    .arrow-center {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8em;
        color: #3e3e3e;
    }

    .search-btn {
        background: #ffc107;
        color: #3e3e3e;
        border: none;
        border-radius: 4px;
        padding: 20px 0;
        font-size: 1.3em;
        font-weight: 700;
        cursor: pointer;
        margin-top: 32px;
        width: 100%;
        box-shadow: 0 4px 14px rgba(255, 193, 7, 0.4);
        transition: background 0.3s;
    }

    .search-btn:hover {
        background: #e0a800;
    }

    @media (max-width: 900px) {
        .outer-container {
            margin: 20px 10px;
        }

        .container {
            padding: 24px;
        }

        .swap-row {
            flex-direction: column;
            gap: 16px;
        }
    }
</style>

<div class="outer-container">
    <div class="header">ระบบจองตั๋วเครื่องบิน</div>
    <div class="container">
        <form class="search-container" action="{{ url('/search-flights') }}" method="get">
            <div class="swap-row">
                <!-- ต้นทาง -->
                <div class="search-group">
                    <label for="departure" class="search-label">ต้นทาง</label>
                    <select class="search-select" name="departure" id="departure" required>
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
                                {{ $dep['city'] ? $dep['city'].' ' : '' }}{{ $dep['name'] }} ({{ $dep['code'] }}){{ $dep['country'] ? ' - '.$dep['country'] : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="arrow-center"><i class="fas fa-plane-departure"></i></div>

                <!-- ปลายทาง -->
                <div class="search-group">
                    <label for="arrival" class="search-label">ปลายทาง</label>
                    <select class="search-select" name="arrival" id="arrival" required>
                        <option value="">เลือกสนามบินปลายทาง</option>
                    </select>
                </div>
            </div>

            <!-- วันที่ -->
            <div class="search-group" style="max-width: 320px; margin: 0 auto;">
                <label for="depart_date" class="search-label">วันออกเดินทาง</label>
                <input class="search-input" type="date" name="depart_date" id="depart_date" required>
            </div>

            <!-- ปุ่มค้นหา -->
            <button class="search-btn" type="submit">
                <i class="fas fa-plane-departure" style="margin-right: 8px;"></i> ค้นหาเที่ยวบิน
            </button>
        </form>
    </div>
</div>

<script>
    const allRoutes = @json($allRoutes ?? []);

    document.getElementById('departure').addEventListener('change', function () {
        const depCode = this.value;
        const arrivalSelect = document.getElementById('arrival');
        arrivalSelect.innerHTML = '<option value="">เลือกสนามบินปลายทาง</option>';

        if (depCode && allRoutes[depCode]) {
            const seen = new Set();
            allRoutes[depCode].forEach(arr => {
                if (arr.code && !seen.has(arr.code)) {
                    seen.add(arr.code);
                    let label = (arr.city ? arr.city + ' ' : '') + arr.name;
                    label += ` (${arr.code})${arr.country ? ' - ' + arr.country : ''}`;
                    arrivalSelect.innerHTML += `<option value="${arr.code}">${label}</option>`;
                }
            });
        }
    });
</script>

@endsection
