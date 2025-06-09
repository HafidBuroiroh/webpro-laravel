<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
        $this->baseUrl = config('rajaongkir.base_url');
    }

    public function getProvinces(): array
    {
        return Http::withHeaders([
            'key' => $this->apiKey,
        ])->get($this->baseUrl . '/province')->json();
    }

    public function getCities($provinceId): array
    {
        return Http::withHeaders([
            'key' => $this->apiKey,
        ])->get($this->baseUrl . '/city', [
            'province' => $provinceId,
        ])->json();
    }

    public function checkOngkir($origin, $destination, $weight, $courier): array
    {
        return Http::withHeaders([
            'key' => $this->apiKey,
        ])->post($this->baseUrl . '/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ])->json();
    }
}
