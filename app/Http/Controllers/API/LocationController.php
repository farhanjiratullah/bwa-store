<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function provinces() {
        $provinces = Http::timeout(10)->withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->get('https://api.rajaongkir.com/starter/province')['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Get all provinces',
            'data' => $provinces
        ]);
    }

    public function cities($province_id) {
        $cities = Http::timeout(10)->withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $province_id
        ])['rajaongkir']['results'];

        $city = Http::timeout(10)->withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->get('https://api.rajaongkir.com/starter/city', [
            'id' => '79'
        ]);

        return $city;

        return response()->json([
            'success' => true,
            'message' => 'Get cities by province_id: ' . $province_id,
            'data' => [
                'cities' => $cities,
                // 'city' => $cities->whereProvinceId($province_id)
            ]
        ]);
    }

    // public function city($province_id) {
    //     $city = Http::timeout(10)->withHeaders([
    //         'key' => env('RAJAONGKIR_KEY')
    //     ])->get('https://api.rajaongkir.com/starter/city', [
    //         'province' => $province_id
    //     ])['rajaongkir']['results'];

    //     $city->find($province_id);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Get cities by province_id: ' . $province_id,
    //         'data' => $city
    //     ]);
    // }

    public function checkOngkir(Request $request) {
        $ongkir = Http::timeout(10)->withHeaders([
            'key' => env('RAJAONGKIR_KEY')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier
        ])['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Result Cost Ongkir',
            'data'    => $ongkir    
        ]);
    }
}
