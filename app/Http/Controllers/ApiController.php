<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ApiController extends Controller
{

    public function bookingForm()
    {
        $apiKey = '192d1ed0ade57c962931a3342b188c17';
        $url = 'https://api.aviationstack.com/v1/flights';
        $params = ['access_key' => $apiKey];

        // ใช้ cacheKey เดียวกับ fetchFlights
        $cacheKey = 'flights_api_' . md5(json_encode($params));
        $flights = \Cache::remember($cacheKey, 6000, function () use ($url, $params) {
            $response = \Illuminate\Support\Facades\Http::get($url, $params);
            return $response->successful() ? $response->json() : ['data' => []];
        });

        return view('booking', compact('flights'));
    }

    public function searchFlights(\Illuminate\Http\Request $request)
    {
        $apiKey = '192d1ed0ade57c962931a3342b188c17';
        $url = 'https://api.aviationstack.com/v1/flights';
        $params = ['access_key' => $apiKey,];

        $cacheKey = 'flights_api_' . md5(json_encode($params));
        $flights = \Cache::remember($cacheKey, 6000, function () use ($url, $params) {
            $response = \Illuminate\Support\Facades\Http::get($url, $params);
            return $response->successful() ? $response->json() : ['data' => []];
        });

        // Filter เฉพาะ flight ที่ตรงกับที่เลือก
        $departure = $request->input('departure');
        $arrival = $request->input('arrival');
        $depart_date = $request->input('depart_date');

        $results = [];
        if (isset($flights['data'])) {
            foreach ($flights['data'] as $flight) {
                $depCode = $flight['departure']['iata'] ?? '';
                $arrCode = $flight['arrival']['iata'] ?? '';
                $date = isset($flight['flight_date']) ? date('Y-m-d', strtotime($flight['flight_date'])) : null;

                if (
                    $depCode == $departure &&
                    $arrCode == $arrival &&
                    (!$depart_date || $date == $depart_date)
                ) {
                    $results[] = $flight;
                }
            }
        }

        return view('search-results', compact('results', 'departure', 'arrival', 'depart_date'));
    }
}