<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DokuService
{
    protected string $clientId;
    protected string $secretKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->clientId = config('doku.client_id');
        $this->secretKey = config('doku.secret_key');
        $this->baseUrl = config('doku.base_url');
    }

    /**
     * Check if DOKU credentials are configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->clientId) && !empty($this->secretKey);
    }

    /**
     * Generate HMAC-SHA256 signature for DOKU SNAP API.
     */
    protected function generateSignature(string $method, string $path, string $body, string $timestamp): string
    {
        $digest = base64_encode(hash('sha256', $body, true));
        $componentSignature = "Client-Id:{$this->clientId}\n"
            . "Request-Id:" . Str::uuid() . "\n"
            . "Request-Timestamp:{$timestamp}\n"
            . "Request-Target:{$path}\n"
            . "Digest:{$digest}";

        return 'HMACSHA256=' . base64_encode(
            hash_hmac('sha256', $componentSignature, $this->secretKey, true)
        );
    }

    /**
     * Generate common headers for DOKU API request.
     */
    protected function buildHeaders(string $path, string $body): array
    {
        $requestId = (string) Str::uuid();
        $timestamp = now()->toIso8601String();
        $digest = base64_encode(hash('sha256', $body, true));

        // Build component signature string
        $componentSignature = "Client-Id:{$this->clientId}\n"
            . "Request-Id:{$requestId}\n"
            . "Request-Timestamp:{$timestamp}\n"
            . "Request-Target:{$path}\n"
            . "Digest:{$digest}";

        $signature = 'HMACSHA256=' . base64_encode(
            hash_hmac('sha256', $componentSignature, $this->secretKey, true)
        );

        return [
            'Client-Id' => $this->clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => $signature,
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Create BSI (Mandiri Syariah) Virtual Account payment code.
     *
     * @param  string  $invoiceNumber  Unique invoice/order ID
     * @param  int     $amount         Payment amount in IDR
     * @param  string  $customerName   Customer full name
     * @param  string  $customerEmail  Customer email
     * @param  int     $expiryMinutes  Expiry time in minutes (default 1440 = 24h)
     * @return array   ['success' => bool, 'va_number' => string|null, 'data' => array]
     */
    public function createBsiVirtualAccount(
        string $invoiceNumber,
        int $amount,
        string $customerName,
        string $customerEmail = '',
        int $expiryMinutes = 1440
    ): array {
        $path = '/mandiri-syariah-virtual-account/v2/payment-code';

        $body = [
            'order' => [
                'invoice_number' => $invoiceNumber,
                'amount' => $amount,
            ],
            'virtual_account_info' => [
                'expired_time' => $expiryMinutes,
                'reusable_status' => false,
                'info1' => 'Pembayaran PPDB',
                'info2' => $customerName,
                'info3' => 'SMP Muhammadiyah Kaliwiro',
            ],
            'customer' => [
                'name' => $customerName,
                'email' => $customerEmail ?: 'noemail@ppdb.local',
            ],
        ];

        $bodyJson = json_encode($body);
        $headers = $this->buildHeaders($path, $bodyJson);

        try {
            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->post($this->baseUrl . $path, $body);

            $data = $response->json();

            Log::info('DOKU BSI VA Response', [
                'status' => $response->status(),
                'body' => $data
            ]);

            if ($response->successful() && isset($data['virtual_account_info']['virtual_account_number'])) {
                return [
                    'success' => true,
                    'va_number' => $data['virtual_account_info']['virtual_account_number'],
                    'how_to_pay_page' => $data['virtual_account_info']['how_to_pay_page'] ?? null,
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'va_number' => null,
                'message' => $data['error']['message'] ?? ($data['message'] ?? 'Unknown DOKU error'),
                'data' => $data,
            ];
        } catch (\Exception $e) {
            Log::error('DOKU BSI VA Error', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'va_number' => null,
                'message' => $e->getMessage(),
                'data' => [],
            ];
        }
    }

    /**
     * Create QRIS payment code.
     *
     * @param  string  $invoiceNumber  Unique invoice/order ID
     * @param  int     $amount         Payment amount in IDR
     * @param  int     $expiryMinutes  Expiry time in minutes (default 30)
     * @return array
     */
    public function createQris(
        string $invoiceNumber,
        int $amount,
        int $expiryMinutes = 30
    ): array {
        $path = '/qris/v1/payment-code';

        $body = [
            'order' => [
                'invoice_number' => $invoiceNumber,
                'amount' => $amount,
            ],
            'qris_info' => [
                'expired_time' => $expiryMinutes,
            ],
        ];

        $bodyJson = json_encode($body);
        $headers = $this->buildHeaders($path, $bodyJson);

        try {
            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->post($this->baseUrl . $path, $body);

            $data = $response->json();

            Log::info('DOKU QRIS Response', [
                'status' => $response->status(),
                'body' => $data
            ]);

            if ($response->successful() && isset($data['qris_info']['qris_url'])) {
                return [
                    'success' => true,
                    'qris_url' => $data['qris_info']['qris_url'],
                    'qris_image' => $data['qris_info']['qris_url'],
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'qris_url' => null,
                'message' => $data['error']['message'] ?? ($data['message'] ?? 'Unknown DOKU error'),
                'data' => $data,
            ];
        } catch (\Exception $e) {
            Log::error('DOKU QRIS Error', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'qris_url' => null,
                'message' => $e->getMessage(),
                'data' => [],
            ];
        }
    }

    /**
     * Verify DOKU notification signature.
     */
    public function verifyNotification(string $signature, string $body, string $requestId, string $timestamp, string $path): bool
    {
        $digest = base64_encode(hash('sha256', $body, true));

        $componentSignature = "Client-Id:{$this->clientId}\n"
            . "Request-Id:{$requestId}\n"
            . "Request-Timestamp:{$timestamp}\n"
            . "Request-Target:{$path}\n"
            . "Digest:{$digest}";

        $expectedSignature = 'HMACSHA256=' . base64_encode(
            hash_hmac('sha256', $componentSignature, $this->secretKey, true)
        );

        return hash_equals($expectedSignature, $signature);
    }
}
