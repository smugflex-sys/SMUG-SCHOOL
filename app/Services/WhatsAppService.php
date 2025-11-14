<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Architect's Note:
     * This is a placeholder for a real WhatsApp API integration. In a production
     * environment, you would replace the Log::info() call with an actual HTTP
     * request to a service like Twilio's WhatsApp API, Meta's API, etc.
     * The structure is here, ready for your API keys.
     *
     * @param string $recipientPhoneNumber The phone number in international format (e.g., 2348012345678)
     * @param string $message The message content to be sent.
     */
    public static function sendMessage(string $recipientPhoneNumber, string $message): void
    {
        // Placeholder: Log the message instead of sending it.
        // In production, this would be an API call.
        Log::info("WhatsApp message to {$recipientPhoneNumber}: \"{$message}\"");

        // Example of a real API call (do not uncomment without an actual service)
        // Http::withToken(config('services.twilio.token'))
        //     ->asForm()
        //     ->post('https://api.twilio.com/...', [
        //         'To' => 'whatsapp:' . $recipientPhoneNumber,
        //         'From' => 'whatsapp:' . config('services.twilio.whatsapp_from'),
        //         'Body' => $message,
        //     ]);
    }
}