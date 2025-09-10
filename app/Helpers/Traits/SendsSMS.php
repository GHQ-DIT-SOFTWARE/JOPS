<?php

namespace App\Helpers\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait SendsSMS
{
    /**
     * Send SMS using mNotify API
     *
     * @param mixed $recipient User object or phone number
     * @param string $message
     * @return bool
     */
    public function sendSMS($recipient, string $message): bool
    {
        try {
            // Handle different recipient types
            $phoneNumber = is_string($recipient) ? $recipient : ($recipient->phone ?? null);
            
            if (!$phoneNumber) {
                $recipientId = is_object($recipient) ? ($recipient->id ?? 'unknown') : 'unknown';
                Log::warning("No phone number found for recipient", ['recipient_id' => $recipientId]);
                return false;
            }

            // Validate phone number format (basic validation)
            if (!$this->validatePhoneNumber($phoneNumber)) {
                Log::warning("Invalid phone number format", ['phone' => $phoneNumber]);
                return false;
            }

            $apiKey = config('services.mnotify.api_key'); // Use config instead of env()
            $senderId = config('services.mnotify.sender_id');

            if (!$apiKey || !$senderId) {
                Log::error("MNotify API credentials not configured");
                return false;
            }

            $endpoint = "https://app.mnotify.com/api/sms/quick";

            $payload = [
                'recipient' => [$this->formatPhoneNumber($phoneNumber)],
                'sender' => $senderId,
                'message' => $message,
                'is_schedule' => false, // Use boolean instead of string
                'schedule_date' => ''
            ];

            $response = Http::timeout(30)
                ->retry(3, 100)
                ->withHeaders([
                    'Authorization' => "Bearer {$apiKey}",
                    'Content-Type' => 'application/json'
                ])->post($endpoint, $payload);

            if ($response->successful()) {
                Log::info("SMS sent successfully", [
                    'phone' => $phoneNumber,
                    'message_length' => strlen($message)
                ]);
                return true;
            }

            Log::error("Failed to send SMS", [
                'phone' => $phoneNumber,
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error("Exception occurred while sending SMS", [
                'error' => $e->getMessage(),
                'phone' => $phoneNumber ?? 'unknown'
            ]);
            return false;
        }
    }

    /**
     * Validate phone number format
     */
    protected function validatePhoneNumber(string $phone): bool
    {
        // Remove any non-digit characters
        $cleanedPhone = preg_replace('/[^0-9]/', '', $phone);
        
        // Basic validation for Ghana numbers (adjust as needed)
        return strlen($cleanedPhone) >= 10 && strlen($cleanedPhone) <= 15;
    }

    /**
     * Format phone number for API
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove any non-digit characters and ensure proper format
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        
        // If number starts with 0, convert to international format
        if (strlen($cleaned) === 10 && strpos($cleaned, '0') === 0) {
            return '233' . substr($cleaned, 1);
        }
        
        return $cleaned;
    }

    /**
     * Send bulk SMS with chunking for large numbers
     */
    public function sendBulkSMS(array $recipients, string $message): array
    {
        $results = ['success' => 0, 'failed' => 0];
        
        foreach ($recipients as $recipient) {
            $sent = $this->sendSMS($recipient, $message);
            $sent ? $results['success']++ : $results['failed']++;
        }
        
        return $results;
    }
}