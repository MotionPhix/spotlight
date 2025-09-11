<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayChanguService
{
    protected string $baseUrl;
    protected string $secretKey;
    protected string $publicKey;
    protected string $webhookSecret;

    public function __construct()
    {
        $this->baseUrl = config('services.paychangu.base_url');
        $this->secretKey = config('services.paychangu.secret_key');
        $this->publicKey = config('services.paychangu.public_key');
        $this->webhookSecret = config('services.paychangu.webhook_secret');
    }

    /**
     * Create a payment request
     */
    public function createPayment(array $data): array
    {
        // Split full name into first and last name
        $nameParts = explode(' ', $data['full_name'], 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        $payload = [
            'tx_ref' => $data['tx_ref'],
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'MWK',
            'email' => $data['email'] ?? null,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'callback_url' => $data['callback_url'],
            'return_url' => $data['return_url'],
            'customization' => [
                'title' => 'Spotlight Consultancy - Artisan Skills Training',
                'description' => 'Registration fee for 6-month artisan skills training program',
            ],
            'meta' => [
                'branch' => $data['branch'] ?? 'Spotlight Consultancy',
                'phone' => $data['phone_number'] ?? null,
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/payment', $payload);

            Log::info('PayChangu Payment Creation', [
                'payload' => $payload,
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                return [
                    'success' => true,
                    'data' => $responseData,
                    'link' => $responseData['data']['checkout_url'] ?? null,
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['message'] ?? 'Payment creation failed',
                'details' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('PayChangu Payment Creation Error', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);

            return [
                'success' => false,
                'error' => 'Failed to create payment: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Verify a payment
     */
    public function verifyPayment(string $txRef): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/verify-payment/' . $txRef);

            Log::info('PayChangu Payment Verification', [
                'tx_ref' => $txRef,
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'data' => $data,
                    'status' => $data['status'] ?? 'unknown',
                    'amount' => $data['amount'] ?? 0,
                    'currency' => $data['currency'] ?? 'MWK',
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['message'] ?? 'Payment verification failed',
                'details' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('PayChangu Payment Verification Error', [
                'error' => $e->getMessage(),
                'tx_ref' => $txRef,
            ]);

            return [
                'success' => false,
                'error' => 'Failed to verify payment: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        if (!$this->webhookSecret) {
            Log::warning('PayChangu webhook secret not configured');
            return false;
        }

        $computedSignature = hash_hmac('sha256', $payload, $this->webhookSecret);
        
        Log::info('PayChangu Webhook Signature Verification', [
            'computed' => $computedSignature,
            'received' => $signature,
            'match' => hash_equals($computedSignature, $signature),
        ]);

        return hash_equals($computedSignature, $signature);
    }

    /**
     * Handle webhook callback with proper verification
     */
    public function handleWebhook(string $payload, ?string $signature = null): array
    {
        // Verify webhook signature for security
        if ($signature && !$this->verifyWebhookSignature($payload, $signature)) {
            Log::warning('PayChangu Webhook signature verification failed');
            return [
                'success' => false,
                'error' => 'Invalid webhook signature',
            ];
        }

        $data = json_decode($payload, true);
        
        if (!$data) {
            return [
                'success' => false,
                'error' => 'Invalid JSON payload',
            ];
        }

        $txRef = $data['tx_ref'] ?? $data['reference'] ?? null;
        $status = $data['status'] ?? null;
        $amount = $data['amount'] ?? 0;
        $eventType = $data['event_type'] ?? null;

        Log::info('PayChangu Webhook Received', [
            'event_type' => $eventType,
            'tx_ref' => $txRef,
            'status' => $status,
            'amount' => $amount,
        ]);

        if (!$txRef) {
            return [
                'success' => false,
                'error' => 'Missing transaction reference',
            ];
        }

        return [
            'success' => true,
            'tx_ref' => $txRef,
            'status' => $status,
            'amount' => $amount,
            'event_type' => $eventType,
            'data' => $data,
        ];
    }

    /**
     * Generate a unique transaction reference
     */
    public function generateTxRef(int $userId): string
    {
        return 'spotlight_' . $userId . '_' . time() . '_' . mt_rand(1000, 9999);
    }
}