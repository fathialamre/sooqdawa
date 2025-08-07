<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Http\Common\Responses\BaseResponse;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Http\Resources\UserProfileResource;
use App\Http\Requests\Api\PhoneLoginRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\PhoneRegisterRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\ForgotPasswordRequest;

class AuthController extends Controller
{
    /**
     * Generate OTP for phone registration
     *
     * Creates OTP and stores registration data in cache for verification.
     */
    public function phoneRegister(PhoneRegisterRequest $request)
    {
        try {
            $validated = $request->validated();
            
            $cacheKey = 'register_otp_' . $validated['phone'];
            
            // Check if phone already exists in cache
            if (Cache::has($cacheKey)) {
                // Get the cached data to extract the creation time
                $cachedData = Cache::get($cacheKey);
                $createdAt = $cachedData['created_at'] ?? now();
                $expiryTime = $createdAt->addMinutes(3);
                $ttlSeconds = max(0, round(now()->diffInSeconds($expiryTime, false)));
                
                return BaseResponse::success([
                    'phone' => $validated['phone'],
                    'ttl' => $ttlSeconds,
                    'otp' => '123456', // In production, this should be sent via SMS
                ], __('messages.auth.otp_already_generated'));
            }
            
            // Generate OTP (default 123456)
            $otp = '123456';
            
            // Store registration data in cache for 3 minutes
            $expiryTime = now()->addMinutes(3);
            Cache::put($cacheKey, [
                'phone' => $validated['phone'],
                'name' => $validated['name'],
                'password' => $validated['password'],
                'fcm_token' => $validated['fcm_token'] ?? null,
                'otp' => $otp,
                'created_at' => now(),
            ], $expiryTime);

            return BaseResponse::success([
                'phone' => $validated['phone'],
                'message' => __('messages.auth.otp_sent'),
                'ttl' => 180, // 3 minutes in seconds
                'otp' => $otp, // In production, this should be sent via SMS
            ], __('messages.auth.otp_generated'));
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e);
        } catch (\Exception $e) {
            return BaseResponse::serverError(__('messages.auth.registration_failed'));
        }
    }

    /**
     * Verify OTP and create user account
     *
     * Verifies OTP and creates user account from cached data.
     */
    public function verifyRegistrationOtp(VerifyOtpRequest $request)
    {
        try {
            $validated = $request->validated();
            
            // Get cached registration data
            $cacheKey = 'register_otp_' . $validated['phone'];
            $registrationData = Cache::get($cacheKey);
            
            if (!$registrationData) {
                return BaseResponse::error(__('messages.auth.otp_expired'), 400);
            }
            
            // Verify OTP
            if ($registrationData['otp'] !== $validated['otp']) {
                return BaseResponse::error(__('messages.auth.invalid_otp'), 400);
            }
            
            // Create user account
            try {
                $user = User::create([
                    'name' => $registrationData['name'],
                    'phone' => $registrationData['phone'],
                    'password' => Hash::make($registrationData['password']),
                    'fcm_token' => $registrationData['fcm_token'],
                    'account_verified_at' => now(),
                ]);
            } catch (\Exception $e) {
                Log::error('User creation failed: ' . $e->getMessage());
                Log::error('Registration data: ' . json_encode($registrationData));
                throw $e;
            }

            // Clear cache
            Cache::forget($cacheKey);

            // Generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            return BaseResponse::success(
                new AuthResource($user, $token),
                __('messages.auth.registration_successful'), 
                201
            );
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e);
        } catch (\Exception $e) {
            Log::error('Registration verification failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return BaseResponse::serverError(__('messages.auth.registration_verification_failed'));
        }
    }

    /**
     * Login with phone number
     *
     * Authenticates a user with phone and password, returns an authentication token.
     */
    public function phoneLogin(PhoneLoginRequest $request)
    {
        try {
            $validated = $request->validated();
            
            $user = User::where('phone', $validated['phone'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return BaseResponse::unauthorized(__('messages.auth.invalid_credentials'));
            }

            // Update FCM token if provided
            if (isset($validated['fcm_token'])) {
                $user->update(['fcm_token' => $validated['fcm_token']]);
            }

            // Revoke all existing tokens for this user
            $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return BaseResponse::success(
                new AuthResource($user, $token),
                __('messages.auth.login_successful')
            );
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e);
        } catch (\Exception $e) {
            return BaseResponse::serverError(__('messages.auth.login_failed'));
        }
    }

    /**
     * Forgot password - send OTP
     *
     * Generates OTP for password reset.
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $validated = $request->validated();
            
            $user = User::where('phone', $validated['phone'])->first();
            
            if (!$user) {
                return BaseResponse::error(__('messages.auth.phone_not_found'), 404);
            }
            
            // Generate OTP (default 123456)
            $otp = '123456';
            
            // Store OTP in cache for 10 minutes
            $cacheKey = 'forgot_password_otp_' . $validated['phone'];
            Cache::put($cacheKey, [
                'phone' => $validated['phone'],
                'otp' => $otp,
                'created_at' => now(),
            ], now()->addMinutes(10));

            return BaseResponse::success([
                'phone' => $validated['phone'],
                'message' => __('messages.auth.otp_sent'),
                'otp' => $otp, // In production, this should be sent via SMS
            ], __('messages.auth.password_reset_otp_sent'));
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e);
        } catch (\Exception $e) {
            return BaseResponse::serverError(__('messages.auth.forgot_password_failed'));
        }
    }

    /**
     * Reset password with OTP
     *
     * Verifies OTP and resets password, returns authentication token.
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $validated = $request->validated();
            
            // Get cached OTP data
            $cacheKey = 'forgot_password_otp_' . $validated['phone'];
            $otpData = Cache::get($cacheKey);
            
            if (!$otpData) {
                return BaseResponse::error(__('messages.auth.otp_expired'), 400);
            }
            
            // Verify OTP
            if ($otpData['otp'] !== $validated['otp']) {
                return BaseResponse::error(__('messages.auth.invalid_otp'), 400);
            }
            
            // Find user and update password
            $user = User::where('phone', $validated['phone'])->first();
            
            if (!$user) {
                return BaseResponse::error(__('messages.auth.user_not_found'), 404);
            }
            
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
            
            // Clear cache
            Cache::forget($cacheKey);
            
            // Revoke all existing tokens
            $user->tokens()->delete();
            
            // Generate new token
            $token = $user->createToken('auth_token')->plainTextToken;

            return BaseResponse::success(
                new AuthResource($user, $token),
                __('messages.auth.password_reset_successful')
            );
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e);
        } catch (\Exception $e) {
            return BaseResponse::serverError(__('messages.auth.password_reset_failed'));
        }
    }

    /**
     * Logout user
     *
     * Revokes the current authentication token.
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();

            return BaseResponse::message(__('messages.auth.logout_successful'));
        } catch (\Exception $e) {
            return BaseResponse::serverError(__('messages.auth.logout_failed'));
        }
    }

    /**
     * Get user profile
     *
     * Returns the authenticated user's profile information.
     */
    public function profile(Request $request)
    {
        try {
            return BaseResponse::success(
                new UserProfileResource($request->user())
            );
        } catch (\Exception $e) {
            return BaseResponse::serverError(__('messages.auth.profile_fetch_failed'));
        }
    }

    /**
     * Logout from all devices
     *
     * Revokes all authentication tokens for the current user.
     */
    public function logoutAll(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return BaseResponse::message(__('messages.auth.logout_all_successful'));
        } catch (\Exception $e) {
            return BaseResponse::serverError(__('messages.auth.logout_all_failed'));
        }
    }
}
