<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Http\Controllers\Api\AuthController;
use App\Http\Requests\Api\PhoneRegisterRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use Illuminate\Support\Facades\Cache;

echo "=== Debugging AuthController ===\n\n";

// Test 1: Phone Registration
echo "1. Testing Phone Registration...\n";
$registerData = [
    'phone' => '+1234567890',
    'name' => 'Test User',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'fcm_token' => 'test_fcm_token'
];

$registerRequest = new PhoneRegisterRequest();
$registerRequest->replace($registerData);

$controller = new AuthController();
$response = $controller->phoneRegister($registerRequest);

echo "Status: " . $response->getStatusCode() . "\n";
$data = json_decode($response->getContent(), true);
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
echo "Phone: " . $data['data']['phone'] . "\n";
echo "OTP: " . $data['data']['otp'] . "\n";
echo "Cache exists: " . (Cache::has('register_otp_+1234567890') ? 'Yes' : 'No') . "\n\n";

// Test 2: Verify OTP
echo "2. Testing OTP Verification...\n";
$verifyData = [
    'phone' => '+1234567890',
    'otp' => '123456'
];

$verifyRequest = new VerifyOtpRequest();
$verifyRequest->replace($verifyData);

try {
    $response = $controller->verifyRegistrationOtp($verifyRequest);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    $data = json_decode($response->getContent(), true);
    echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
    if ($data['success']) {
        echo "User created: " . $data['data']['user']['name'] . "\n";
        echo "Token type: " . $data['data']['token_type'] . "\n";
    } else {
        echo "Error: " . json_encode($data) . "\n";
    }
    echo "Cache cleared: " . (!Cache::has('register_otp_+1234567890') ? 'Yes' : 'No') . "\n";
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Debug Complete ===\n"; 