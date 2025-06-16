<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Booking;

class ApiController extends Controller
{
    public function bookingForm()
    {
        $apiKey = '192d1ed0ade57c962931a3342b188c17';
        $url = 'https://api.aviationstack.com/v1/flights';
        $params = ['access_key' => $apiKey];

        $cacheKey = 'flights_api_' . md5(json_encode($params));

        $flights = Cache::rememberForever($cacheKey, function () use ($url, $params) {
            $response = Http::get($url, $params);
            return $response->successful() ? $response->json() : ['data' => []];
        });

        return view('booking', compact('flights'));
    }

    public function searchFlights(Request $request)
    {
        $apiKey = '192d1ed0ade57c962931a3342b188c17';
        $url = 'https://api.aviationstack.com/v1/flights';
        $params = ['access_key' => $apiKey];

        $cacheKey = 'flights_api_' . md5(json_encode($params));

        $flights = Cache::rememberForever($cacheKey, function () use ($url, $params) {
            $response = Http::get($url, $params);
            return $response->successful() ? $response->json() : ['data' => []];
        });

        $departure = $request->input('departure');
        $arrival = $request->input('arrival');
        $depart_date = $request->input('depart_date');

        $results = [];
        $indexedResults = [];

        if (isset($flights['data'])) {
            foreach ($flights['data'] as $index => $flight) {
                $depCode = $flight['departure']['iata'] ?? '';
                $arrCode = $flight['arrival']['iata'] ?? '';
                $date = isset($flight['flight_date']) ? date('Y-m-d', strtotime($flight['flight_date'])) : null;

                if (
                    $depCode == $departure &&
                    $arrCode == $arrival &&
                    (!$depart_date || $date == $depart_date)
                ) {
                    $results[] = $flight;
                    $indexedResults[$index] = $flight;
                }
            }
        }

        // เก็บไว้ใน session เพื่อเรียกใช้ตอนเลือกเที่ยวบิน
        session(['search_results' => $indexedResults]);

        return view('search-results', compact('results', 'departure', 'arrival', 'depart_date'));
    }

    public function showBookingDetails(Request $request)
    {
        $flight = [];
        if ($request->has('flight')) {
            $flight = json_decode(base64_decode($request->input('flight')), true);
            // เก็บ flight ลง session เพื่อใช้ตอนบันทึก
            $request->session()->put('selected_flight', $flight);
        } else {
            $flight = $request->session()->get('selected_flight', []);
        }
        return view('booking-details', compact('flight'));
    }

    public function confirmBooking(Request $request)
    {
        $passengerData = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        $flight = $request->session()->get('selected_flight', []);
        Booking::create([
            'flight_data' => json_encode($flight),
            'passenger_data' => json_encode($passengerData),
        ]);

        return redirect()->route('booking-history')->with('success', 'การจองของคุณเสร็จสมบูรณ์แล้ว!');
    }

    public function bookingHistory()
    {
        // ดึงข้อมูลการจองทั้งหมด (หรือเฉพาะของผู้ใช้ ถ้ามีระบบล็อกอิน)
        $bookings = \App\Models\Booking::latest()->get();

        return view('booking-history', compact('bookings'));
    }

    public function showTicket($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        $flight = json_decode($booking->flight_data, true);
        $passenger = json_decode($booking->passenger_data, true);

        return view('ticket', compact('booking', 'flight', 'passenger'));
    }
}
