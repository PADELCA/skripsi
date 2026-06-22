<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PrediksiService
{
    public function getPrediksi(
        string $obat,
        array $data
    )
    {
        if (count($data) !== 14) {

            throw new \Exception(
                "Data harus berjumlah 14 hari!"
            );

        }

        $response = Http::timeout(30)
            ->post(
                'http://127.0.0.1:5000/predict',
                [
                    'obat' => $obat,
                    'input' => $data
                ]
            );

        if ($response->successful()) {

            $result = $response->json();

            if (
                isset($result['status']) &&
                $result['status'] === 'success'
            ) {

                return [
                    'prediction' =>
                        $result['prediction'],

                    'rekomendasi' =>
                        $result['rekomendasi']
                ];
            }

            throw new \Exception(
                'AI Error: ' .
                ($result['message'] ?? 'Unknown error')
            );
        }

        throw new \Exception(
            'Gagal terhubung ke API AI'
        );
    }
}