<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaystackService
{
    protected $baseUrl;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('app.paystack_base_url', 'https://api.paystack.co');
        $this->secretKey = config('app.paystack_secret_key');
    }

    /**
     * Initialize a transaction with Paystack.
     *
     * @param array $data
     * @return array|null
     */
    public function initializeTransaction(array $data): ?array
    {
        $response = Http::withToken($this->secretKey)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post("{$this->baseUrl}/transaction/initialize", $data);

        if ($response->successful() && $response->json()['status']) {
            return $response->json()['data'];
        }

        return null;
    }

    /**
     * Verify a transaction with Paystack.
     *
     * @param string $reference
     * @return array|null
     */
    public function verifyTransaction(string $reference): ?array
    {
        $response = Http::withToken($this->secretKey)
            ->get("{$this->baseUrl}/transaction/verify/{$reference}");

        if ($response->successful() && $response->json()['status']) {
            return $response->json()['data'];
        }

        return null;
    }
}