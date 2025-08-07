<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_phone_register_generates_otp()
    {
        $data = [
            'phone' => '+1234567890',
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'fcm_token' => 'test_fcm_token'
        ];

        $response = $this->postJson('/api/v1/auth/phone/register', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'phone' => '+1234567890',
                    'otp' => '123456'
                ]
            ]);

        // Check if data is cached
        $this->assertTrue(Cache::has('register_otp_+1234567890'));
    }

    public function test_phone_register_with_existing_phone_returns_error()
    {
        // Create a user with the phone number
        User::create([
            'name' => 'Existing User',
            'phone' => '+1234567890',
            'password' => Hash::make('password123'),
        ]);

        $data = [
            'phone' => '+1234567890',
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/v1/auth/phone/register', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
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

        $this->postJson('/api/v1/auth/phone/register', $registerData);

        // Now verify OTP
        $verifyData = [
            'phone' => '+1234567890',
            'otp' => '123456'
        ];

        $response = $this->postJson('/api/v1/auth/phone/verify-otp', $verifyData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'user' => [
                        'name' => 'Test User',
                        'phone' => '+1234567890'
                    ],
                    'token_type' => 'Bearer'
                ]
            ]);

        // Check if user was created
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'phone' => '+1234567890',
            'fcm_token' => 'test_fcm_token'
        ]);

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

        $this->postJson('/api/v1/auth/phone/register', $registerData);

        // Now verify with wrong OTP
        $verifyData = [
            'phone' => '+1234567890',
            'otp' => '000000'
        ];

        $response = $this->postJson('/api/v1/auth/phone/verify-otp', $verifyData);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false
            ]);
    }

    public function test_phone_login_with_valid_credentials()
    {
        // Create a user
        $user = User::create([
            'name' => 'Test User',
            'phone' => '+1234567890',
            'password' => Hash::make('password123'),
            'account_verified_at' => now(),
        ]);

        $loginData = [
            'phone' => '+1234567890',
            'password' => 'password123',
            'fcm_token' => 'new_fcm_token'
        ];

        $response = $this->postJson('/api/v1/auth/phone/login', $loginData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'user' => [
                        'name' => 'Test User',
                        'phone' => '+1234567890'
                    ],
                    'token_type' => 'Bearer'
                ]
            ]);

        // Check if FCM token was updated
        $user->refresh();
        $this->assertEquals('new_fcm_token', $user->fcm_token);
    }

    public function test_phone_login_with_invalid_credentials()
    {
        $loginData = [
            'phone' => '+1234567890',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/v1/auth/phone/login', $loginData);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false
            ]);
    }

    public function test_forgot_password_sends_otp()
    {
        // Create a user
        User::create([
            'name' => 'Test User',
            'phone' => '+1234567890',
            'password' => Hash::make('password123'),
            'account_verified_at' => now(),
        ]);

        $forgotData = [
            'phone' => '+1234567890'
        ];

        $response = $this->postJson('/api/v1/auth/forgot-password', $forgotData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'phone' => '+1234567890',
                    'otp' => '123456'
                ]
            ]);

        // Check if OTP is cached
        $this->assertTrue(Cache::has('forgot_password_otp_+1234567890'));
    }

    public function test_forgot_password_with_nonexistent_phone()
    {
        $forgotData = [
            'phone' => '+1234567890'
        ];

        $response = $this->postJson('/api/v1/auth/forgot-password', $forgotData);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false
            ]);
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
        $this->postJson('/api/v1/auth/forgot-password', ['phone' => '+1234567890']);

        // Reset password
        $resetData = [
            'phone' => '+1234567890',
            'otp' => '123456',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->postJson('/api/v1/auth/reset-password', $resetData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'user' => [
                        'name' => 'Test User',
                        'phone' => '+1234567890'
                    ],
                    'token_type' => 'Bearer'
                ]
            ]);

        // Check if password was updated
        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));

        // Check if cache was cleared
        $this->assertFalse(Cache::has('forgot_password_otp_+1234567890'));
    }

    public function test_reset_password_with_invalid_otp()
    {
        // Create a user
        User::create([
            'name' => 'Test User',
            'phone' => '+1234567890',
            'password' => Hash::make('oldpassword'),
            'account_verified_at' => now(),
        ]);

        // Send forgot password OTP
        $this->postJson('/api/v1/auth/forgot-password', ['phone' => '+1234567890']);

        // Reset password with wrong OTP
        $resetData = [
            'phone' => '+1234567890',
            'otp' => '000000',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->postJson('/api/v1/auth/reset-password', $resetData);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false
            ]);
    }

    public function test_logout_requires_authentication()
    {
        $response = $this->postJson('/api/v1/auth/logout');

        $response->assertStatus(401);
    }

    public function test_logout_with_valid_token()
    {
        // Create and authenticate user
        $user = User::create([
            'name' => 'Test User',
            'phone' => '+1234567890',
            'password' => Hash::make('password123'),
            'account_verified_at' => now(),
        ]);

        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_profile_requires_authentication()
    {
        $response = $this->getJson('/api/v1/auth/profile');

        $response->assertStatus(401);
    }

    public function test_profile_with_valid_token()
    {
        // Create and authenticate user
        $user = User::create([
            'name' => 'Test User',
            'phone' => '+1234567890',
            'password' => Hash::make('password123'),
            'account_verified_at' => now(),
        ]);

        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/v1/auth/profile');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Test User',
                    'phone' => '+1234567890'
                ]
            ]);
    }

    public function test_logout_all_requires_authentication()
    {
        $response = $this->postJson('/api/v1/auth/logout-all');

        $response->assertStatus(401);
    }

    public function test_logout_all_with_valid_token()
    {
        // Create and authenticate user
        $user = User::create([
            'name' => 'Test User',
            'phone' => '+1234567890',
            'password' => Hash::make('password123'),
            'account_verified_at' => now(),
        ]);

        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/v1/auth/logout-all');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }
} 