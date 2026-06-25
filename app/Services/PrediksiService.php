<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PrediksiService
{
    public function getPrediksi(
        int $kodeObat,
        int $bulanKe
    )
    {
        $response = Http::post(
            'http://127.0.0.1:5000/predict',
            [
                'input' => [
                    [
                        $kodeObat,
                        $bulanKe
                    ]
                ]
            ]
        );

        if (!$response->successful())
        {
            throw new \Exception(
                'Flask API tidak merespon'
            );
        }

        $result =
            $response->json();

        return round(
            $result['prediction'],
            2
        );
    }
}