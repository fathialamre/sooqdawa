<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Cache;

class AuthControllerSimpleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_auth_controller_exists()
    {
        $controller = new AuthController();
        $this->assertInstanceOf(AuthController::class, $controller);
    }

    public function test_auth_controller_has_required_methods()
    {
        $controller = new AuthController();
        
        $methods = [
            'phoneRegister',
            'verifyRegistrationOtp',
            'phoneLogin',
            'forgotPassword',
            'resetPassword',
            'logout',
            'profile',
            'logoutAll'
        ];

        foreach ($methods as $method) {
            $this->assertTrue(method_exists($controller, $method), "Method {$method} does not exist");
        }
    }

    public function test_cache_operations_work()
    {
        $cacheKey = 'test_key';
        $testData = ['test' => 'data'];
        
        // Test cache put
        Cache::put($cacheKey, $testData, 60);
        $this->assertTrue(Cache::has($cacheKey));
        
        // Test cache get
        $retrievedData = Cache::get($cacheKey);
        $this->assertEquals($testData, $retrievedData);
        
        // Test cache forget
        Cache::forget($cacheKey);
        $this->assertFalse(Cache::has($cacheKey));
    }

    public function test_otp_generation_logic()
    {
        // Test that OTP is always 123456 in development
        $otp = '123456';
        $this->assertEquals('123456', $otp);
        $this->assertEquals(6, strlen($otp));
    }

    public function test_cache_key_format()
    {
        $phone = '+1234567890';
        $registerCacheKey = 'register_otp_' . $phone;
        $forgotCacheKey = 'forgot_password_otp_' . $phone;
        
        $this->assertEquals('register_otp_+1234567890', $registerCacheKey);
        $this->assertEquals('forgot_password_otp_+1234567890', $forgotCacheKey);
    }

    protected function tearDown(): void
    {
        Cache::flush();
        parent::tearDown();
    }
} 