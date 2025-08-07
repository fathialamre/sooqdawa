<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Api\AuthController;
use App\Http\Requests\Api\PhoneRegisterRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Http\Requests\Api\PhoneLoginRequest;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Mockery;

class AuthControllerUnitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_phone_register_generates_otp()
    {
        $requestData = [
            'phone' => '+1234567890',
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'fcm_token' => 'test_fcm_token'
        ];

        $request = $this->createRequest(PhoneRegisterRequest::class, $requestData);
        $controller = new AuthController();
        $response = $controller->phoneRegister($request);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        
        $this->assertTrue($data['success']);
        $this->assertEquals('+1234567890', $data['data']['phone']);
        $this->assertEquals('123456', $data['data']['otp']);

        // Check if data is cached
        $this->assertTrue(Cache::has('register_otp_+1234567890'));
    }

    public function test_phone_register_with_existing_cache_returns_ttl()
    {
        // First registration
        $requestData1 = [
            'phone' => '+1234567890',
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $request1 = $this->createRequest(PhoneRegisterRequest::class, $requestData1);
        $controller = new AuthController();
        $controller->phoneRegister($request1);

        // Second registration with same phone
        $requestData2 = [
            'phone' => '+1234567890',
            'name' => 'Test User 2',
            'password' => 'password456',
            'password_confirmation' => 'password456',
        ];

        $request2 = $this->createRequest(PhoneRegisterRequest::class, $requestData2);
        $response = $controller->phoneRegister($request2);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        
        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('ttl', $data['data']);
    }

    public function test_verify_registration_otp_creates_user()
    {
        // First register to generate OTP
        $registerData = [
            'phone' => '+1234567890',
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'fcm_token' => 'test_fcm_token'
        ];

        $registerRequest = $this->createRequest(PhoneRegisterRequest::class, $registerData);
        $controller = new AuthController();
        $controller->phoneRegister($registerRequest);

        // Now verify OTP
        $verifyData = [
            'phone' => '+1234567890',
            'otp' => '123456'
        ];

        $verifyRequest = $this->createRequest(VerifyOtpRequest::class, $verifyData);
        $response = $controller->verifyRegistrationOtp($verifyRequest);

        $this->assertEquals(201, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        
        $this->assertTrue($data['success']);
        $this->assertEquals('Test User', $data['data']['user']['name']);
        $this->assertEquals('+1234567890', $data['data']['user']['phone']);
        $this->assertEquals('Bearer', $data['data']['token_type']);

        // Check if cache was cleared
        $this->assertFalse(Cache::has('register_otp_+1234567890'));
    }

    public function test_verify_registration_otp_with_invalid_otp_returns_error()
    {
        // First register to generate OTP
        $registerData = [
            'phone' => '+1234567890',
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $registerRequest = $this->createRequest(PhoneRegisterRequest::class, $registerData);
        $controller = new AuthController();
        $controller->phoneRegister($registerRequest);

        // Now verify with wrong OTP
        $verifyData = [
            'phone' => '+1234567890',
            'otp' => '000000'
        ];

        $verifyRequest = $this->createRequest(VerifyOtpRequest::class, $verifyData);
        $response = $controller->verifyRegistrationOtp($verifyRequest);

        $this->assertEquals(400, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        
        $this->assertFalse($data['success']);
    }

    public function test_forgot_password_sends_otp()
    {
        // Create a user first
        $user = User::create([
            'name' => 'Test User',
            'phone' => '+1234567890',
            'password' => Hash::make('password123'),
            'account_verified_at' => now(),
        ]);

        $requestData = [
            'phone' => '+1234567890'
        ];

        $request = $this->createRequest(ForgotPasswordRequest::class, $requestData);
        $controller = new AuthController();
        $response = $controller->forgotPassword($request);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        
        $this->assertTrue($data['success']);
        $this->assertEquals('+1234567890', $data['data']['phone']);
        $this->assertEquals('123456', $data['data']['otp']);

        // Check if OTP is cached
        $this->assertTrue(Cache::has('forgot_password_otp_+1234567890'));
    }

    public function test_forgot_password_with_nonexistent_phone()
    {
        $requestData = [
            'phone' => '+1234567890'
        ];

        $request = $this->createRequest(ForgotPasswordRequest::class, $requestData);
        $controller = new AuthController();
        $response = $controller->forgotPassword($request);

        $this->assertEquals(404, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        
        $this->assertFalse($data['success']);
    }

    public function test_reset_password_with_valid_otp()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User',
            'phone' => '+1234567890',
            'password' => Hash::make('oldpassword'),
            'account_verified_at' => now(),
        ]);

        // Send forgot password OTP
        $forgotData = ['phone' => '+1234567890'];
        $forgotRequest = $this->createRequest(ForgotPasswordRequest::class, $forgotData);
        
        $controller = new AuthController();
        $controller->forgotPassword($forgotRequest);

        // Reset password
        $resetData = [
            'phone' => '+1234567890',
            'otp' => '123456',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $resetRequest = $this->createRequest(ResetPasswordRequest::class, $resetData);
        $response = $controller->resetPassword($resetRequest);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        
        $this->assertTrue($data['success']);
        $this->assertEquals('Test User', $data['data']['user']['name']);
        $this->assertEquals('+1234567890', $data['data']['user']['phone']);
        $this->assertEquals('Bearer', $data['data']['token_type']);

        // Check if password was updated
        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));

        // Check if cache was cleared
        $this->assertFalse(Cache::has('forgot_password_otp_+1234567890'));
    }

    public function test_reset_password_with_invalid_otp()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User',
            'phone' => '+1234567890',
            'password' => Hash::make('oldpassword'),
            'account_verified_at' => now(),
        ]);

        // Send forgot password OTP
        $forgotData = ['phone' => '+1234567890'];
        $forgotRequest = $this->createRequest(ForgotPasswordRequest::class, $forgotData);
        
        $controller = new AuthController();
        $controller->forgotPassword($forgotRequest);

        // Reset password with wrong OTP
        $resetData = [
            'phone' => '+1234567890',
            'otp' => '000000',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $resetRequest = $this->createRequest(ResetPasswordRequest::class, $resetData);
        $response = $controller->resetPassword($resetRequest);

        $this->assertEquals(400, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        
        $this->assertFalse($data['success']);
    }

    private function createRequest($requestClass, $data)
    {
        $request = new $requestClass();
        $request->replace($data);
        return $request;
    }

    protected function tearDown(): void
    {
        Cache::flush();
        parent::tearDown();
    }
} 