<?php

require_once 'vendor/autoload.php';

use App\Http\Controllers\Api\AuthController;
use App\Http\Requests\Api\PhoneRegisterRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Http\Requests\Api\PhoneLoginRequest;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use Illuminate\Support\Facades\Cache;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing AuthController Flow ===\n\n";

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

$response = $controller->verifyRegistrationOtp($verifyRequest);

echo "Status: " . $response->getStatusCode() . "\n";
$data = json_decode($response->getContent(), true);
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
if ($data['success']) {
    echo "User created: " . $data['data']['user']['name'] . "\n";
    echo "Token type: " . $data['data']['token_type'] . "\n";
}
echo "Cache cleared: " . (!Cache::has('register_otp_+1234567890') ? 'Yes' : 'No') . "\n\n";

// Test 3: Phone Login
echo "3. Testing Phone Login...\n";
$loginData = [
    'phone' => '+1234567890',
    'password' => 'password123',
    'fcm_token' => 'new_fcm_token'
];

$loginRequest = new PhoneLoginRequest();
$loginRequest->replace($loginData);

$response = $controller->phoneLogin($loginRequest);

echo "Status: " . $response->getStatusCode() . "\n";
$data = json_decode($response->getContent(), true);
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
if ($data['success']) {
    echo "User logged in: " . $data['data']['user']['name'] . "\n";
    echo "Token type: " . $data['data']['token_type'] . "\n";
}
echo "\n";

// Test 4: Forgot Password
echo "4. Testing Forgot Password...\n";
$forgotData = [
    'phone' => '+1234567890'
];

$forgotRequest = new ForgotPasswordRequest();
$forgotRequest->replace($forgotData);

$response = $controller->forgotPassword($forgotRequest);

echo "Status: " . $response->getStatusCode() . "\n";
$data = json_decode($response->getContent(), true);
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
echo "OTP sent: " . $data['data']['otp'] . "\n";
echo "Cache exists: " . (Cache::has('forgot_password_otp_+1234567890') ? 'Yes' : 'No') . "\n\n";

// Test 5: Reset Password
echo "5. Testing Reset Password...\n";
$resetData = [
    'phone' => '+1234567890',
    'otp' => '123456',
    'password' => 'newpassword123',
    'password_confirmation' => 'newpassword123'
];

$resetRequest = new ResetPasswordRequest();
$resetRequest->replace($resetData);

$response = $controller->resetPassword($resetRequest);

echo "Status: " . $response->getStatusCode() . "\n";
$data = json_decode($response->getContent(), true);
echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
if ($data['success']) {
    echo "Password reset successful\n";
    echo "Token type: " . $data['data']['token_type'] . "\n";
}
echo "Cache cleared: " . (!Cache::has('forgot_password_otp_+1234567890') ? 'Yes' : 'No') . "\n\n";

echo "=== Test Complete ===\n"; 