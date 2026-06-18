<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PrediksiService
{
    public function getPrediksi(array $data)
    {
        // Pastikan data yang dikirim adalah 7 angka
        if (count($data) !== 7) {
            throw new \Exception("Data harus berjumlah 7 hari!");
        }

        $response = Http::post('http://127.0.0.1:5000/predict', [
            'input' => $data
        ]);

        if ($response->successful()) {
            $result = $response->json();

            // Cek apakah Python mengirim status sukses
            if (isset($result['status']) && $result['status'] === 'success') {
                return $result['prediction'];
            } else {
                // Jika Python mengirim status error, kita lempar pesan errornya
                throw new \Exception("AI Error: " . ($result['message'] ?? 'Unknown error'));
            }
        }

        throw new \Exception("Gagal terhubung ke API AI (Server Python mungkin mati)");
    }
}