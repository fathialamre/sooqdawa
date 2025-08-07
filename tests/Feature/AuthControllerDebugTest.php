<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class AuthControllerDebugTest extends TestCase
{
    use RefreshDatabase;

    public function test_debug_registration_flow()
    {
        echo "\n=== Debugging Registration Flow ===\n";

        // Step 1: Register with phone
        $registerData = [
            'phone' => '+1234567890',
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'fcm_token' => 'test_fcm_token'
        ];

        $response = $this->postJson('/api/v1/auth/phone/register', $registerData);
        
        echo "Registration Status: " . $response->getStatusCode() . "\n";
        $data = json_decode($response->getContent(), true);
        echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
        echo "Phone: " . $data['data']['phone'] . "\n";
        echo "OTP: " . $data['data']['otp'] . "\n";
        echo "Cache exists: " . (Cache::has('register_otp_+1234567890') ? 'Yes' : 'No') . "\n";

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($data['success']);

        // Step 2: Verify OTP
        $verifyData = [
            'phone' => '+1234567890',
            'otp' => '123456'
        ];

        $response = $this->postJson('/api/v1/auth/phone/verify-otp', $verifyData);
        
        echo "\nVerification Status: " . $response->getStatusCode() . "\n";
        $data = json_decode($response->getContent(), true);
        echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
        if ($data['success']) {
            echo "User created: " . $data['data']['user']['name'] . "\n";
            echo "Token type: " . $data['data']['token_type'] . "\n";
        } else {
            echo "Error: " . json_encode($data) . "\n";
        }
        echo "Cache cleared: " . (!Cache::has('register_otp_+1234567890') ? 'Yes' : 'No') . "\n";

        // Let's see what the actual response is
        echo "\nFull Response: " . $response->getContent() . "\n";
        
        // Don't assert anything for now, just debug
        echo "\n=== Debug Complete ===\n";
    }
} 