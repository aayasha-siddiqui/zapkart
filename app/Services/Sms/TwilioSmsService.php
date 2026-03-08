<?php

namespace App\Services\Sms;

use Twilio\Rest\Client;

class TwilioSmsService implements SmsServiceInterface
{
    protected Client $client;
    protected string $from;

    public function __construct()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->from = env('TWILIO_FROM');

        $this->client = new Client($sid, $token);
    }

    // Generic SMS
    public function send(string $phone, string $message): bool
    {
        try {
            $this->client->messages->create($phone, [
                'from' => $this->from,
                'body' => $message,
            ]);
            return true;
        } catch (\Exception $e) {
            dd('Twilio Error → ' . $e->getMessage());
        }
    }

    // Send OTP method
    public function sendOtp(string $phone, int $otp): bool
    {
        $message = "Your OTP code is: {$otp}";
        return $this->send($phone, $message);
    }
}
