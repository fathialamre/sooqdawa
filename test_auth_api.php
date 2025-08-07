<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing AuthController API Endpoints ===\n\n";

// Test 1: Phone Registration
echo "1. Testing Phone Registration...\n";
$registerData = [
    'phone' => '+1234567890',
    'name' => 'Test User',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'fcm_token' => 'test_fcm_token'
];

$response = $this->postJson('/api/v1/auth/phone/register', $registerData);

echo "Status: " . $response->getStatusCode() . "\n";
$data = json_decode($response->getContent(), true);
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
echo "Phone: " . $data['data']['phone'] . "\n";
echo "OTP: " . $data['data']['otp'] . "\n\n";

// Test 2: Verify OTP
echo "2. Testing OTP Verification...\n";
$verifyData = [
    'phone' => '+1234567890',
    'otp' => '123456'
];

$response = $this->postJson('/api/v1/auth/phone/verify-otp', $verifyData);

echo "Status: " . $response->getStatusCode() . "\n";
$data = json_decode($response->getContent(), true);
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
if ($data['success']) {
    echo "User created: " . $data['data']['user']['name'] . "\n";
    echo "Token type: " . $data['data']['token_type'] . "\n";
}
echo "\n";

// Test 3: Phone Login
echo "3. Testing Phone Login...\n";
$loginData = [
    'phone' => '+1234567890',
    'password' => 'password123',
    'fcm_token' => 'new_fcm_token'
];

$response = $this->postJson('/api/v1/auth/phone/login', $loginData);

echo "Status: " . $response->getStatusCode() . "\n";
$data = json_decode($response->getContent(), true);
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
if ($data['success']) {
    echo "User logged in: " . $data['data']['user']['name'] . "\n";
    echo "Token type: " . $data['data']['token_type'] . "\n";
}
echo "\n";

echo "=== Test Complete ===\n"; 