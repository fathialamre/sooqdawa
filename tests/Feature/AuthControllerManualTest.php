<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class AuthControllerManualTest extends TestCase
{
    use RefreshDatabase;

    public function test_phone_registration_flow()
    {
        echo "\n=== Testing Phone Registration Flow ===\n";

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
        $this->assertEquals('+1234567890', $data['data']['phone']);
        $this->assertEquals('123456', $data['data']['otp']);

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

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($data['success']);
        $this->assertEquals('Test User', $data['data']['user']['name']);
        $this->assertEquals('Bearer', $data['data']['token_type']);

        // Step 3: Login with phone
        $loginData = [
            'phone' => '+1234567890',
            'password' => 'password123',
            'fcm_token' => 'new_fcm_token'
        ];

        $response = $this->postJson('/api/v1/auth/phone/login', $loginData);
        
        echo "\nLogin Status: " . $response->getStatusCode() . "\n";
        $data = json_decode($response->getContent(), true);
        echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
        if ($data['success']) {
            echo "User logged in: " . $data['data']['user']['name'] . "\n";
            echo "Token type: " . $data['data']['token_type'] . "\n";
        }

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($data['success']);
        $this->assertEquals('Test User', $data['data']['user']['name']);
        $this->assertEquals('Bearer', $data['data']['token_type']);

        echo "\n=== Registration Flow Test Complete ===\n";
    }

    public function test_forgot_password_flow()
    {
        echo "\n=== Testing Forgot Password Flow ===\n";

        // First create a user
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+1234567890',
            'password' => bcrypt('password123'),
            'account_verified_at' => now(),
        ]);

        // Step 1: Forgot Password
        $forgotData = [
            'phone' => '+1234567890'
        ];

        $response = $this->postJson('/api/v1/auth/forgot-password', $forgotData);
        
        echo "Forgot Password Status: " . $response->getStatusCode() . "\n";
        $data = json_decode($response->getContent(), true);
        echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
        echo "OTP sent: " . $data['data']['otp'] . "\n";
        echo "Cache exists: " . (Cache::has('forgot_password_otp_+1234567890') ? 'Yes' : 'No') . "\n";

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($data['success']);
        $this->assertEquals('123456', $data['data']['otp']);

        // Step 2: Reset Password
        $resetData = [
            'phone' => '+1234567890',
            'otp' => '123456',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->postJson('/api/v1/auth/reset-password', $resetData);
        
        echo "\nReset Password Status: " . $response->getStatusCode() . "\n";
        $data = json_decode($response->getContent(), true);
        echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
        if ($data['success']) {
            echo "Password reset successful\n";
            echo "Token type: " . $data['data']['token_type'] . "\n";
        }
        echo "Cache cleared: " . (!Cache::has('forgot_password_otp_+1234567890') ? 'Yes' : 'No') . "\n";

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($data['success']);
        $this->assertEquals('Bearer', $data['data']['token_type']);

        echo "\n=== Forgot Password Flow Test Complete ===\n";
    }

    public function test_error_cases()
    {
        echo "\n=== Testing Error Cases ===\n";

        // Test 1: Register with existing phone
        $user = \App\Models\User::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'phone' => '+1234567890',
            'password' => bcrypt('password123'),
            'account_verified_at' => now(),
        ]);

        $registerData = [
            'phone' => '+1234567890',
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/v1/auth/phone/register', $registerData);
        
        echo "Duplicate Phone Registration Status: " . $response->getStatusCode() . "\n";
        $this->assertEquals(422, $response->getStatusCode());

        // Test 2: Login with wrong password
        $loginData = [
            'phone' => '+1234567890',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/v1/auth/phone/login', $loginData);
        
        echo "Wrong Password Login Status: " . $response->getStatusCode() . "\n";
        $this->assertEquals(401, $response->getStatusCode());

        // Test 3: Forgot password with non-existent phone
        $forgotData = [
            'phone' => '+9999999999'
        ];

        $response = $this->postJson('/api/v1/auth/forgot-password', $forgotData);
        
        echo "Non-existent Phone Forgot Password Status: " . $response->getStatusCode() . "\n";
        $this->assertEquals(422, $response->getStatusCode());

        echo "\n=== Error Cases Test Complete ===\n";
    }
} 