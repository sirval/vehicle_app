<?php

namespace App\Services;

use App\Constants;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\Utils;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthService 
{
    use ApiResponse, Utils;

    public User $userModel;
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function userLogin($request): JsonResponse
    {
        try {
            $data = [
                'phone' => $request->phone,
                'password' => $request->password,
            ];
            $rules = [
                'phone' => 'required|string',
                'password' => 'required|string',
            ];

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = implode(' ', $validator->errors()->all());
                return $this->response($errors, 409, 'error' ,$errors);
            }

            $credentials = $request->only('phone','password');
            

            if ($request->has('remember') && $request->remember == true) {
                $token = Auth::attempt($credentials, true);
                $message = 'Login Successful and user account set to remember';
            } else {
                $token = Auth::attempt($credentials);
                $message = 'Login Successful';
            }

            if (!$token) {
                return $this->response(null, 401, 'error', 'Unauthorized');
            }
            $user = $this->userModel->find(Auth::id());
            
            if ($user->is_verified == Constants::IS_NOT_VERIFIED_USER) {
                Auth::logout();
                return $this->response(null, 409, 'error', 'User is not yet verified!');
            }
            return $this->response($this->tokenResponse($user, $token), 200, 'success', $message);
            
        } catch (\Throwable $th) {
            return $this->response($th->getMessage(), 500, 'error', 'A server error occurred.');
        }
    }

    public function me()
    {
        return $this->response(new UserResource(Auth::user()));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return $this->response(null, 401, 'success', 'Successfully logged out');
    }

    public function refresh()
    {
        $user = Auth::user();
        $token = Auth::refresh();
        return $this->response($this->tokenResponse($user, $token), 200, 'success', 'Token refreshed successfully');
    }

    private function tokenResponse($user, $token)
    {
        $user = new UserResource($user);
        return [
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
                'token_expires' => config('jwt.ttl') * 60,
            ],
        ];
    }

    public function userRegister($request)
    {
        try {
            $data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => $request->password,
            ];
            $rules = [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|unique:users,phone',
                'password' => 'required|string|min:6',
            ];

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = implode(' ', $validator->errors()->all());
                return $this->response($errors, 409, 'error' ,$errors);
            }
            $verif_code = $this->generateVerificationCode($request->phone);
            
            $result = $this->userModel->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'verif_code' => $verif_code,
                'verif_expires_at' =>  Carbon::now()->addMinutes(30),
                'password' => Hash::make($request->password),
            ]);

            if ($this->sendSms($result) === true) {
                return $this->response(['user_id' => $result->id], 201, 'success', 'Check your phone number for verification code. If you didn\'t receive otp, use '.$result->verif_code.' for test purposes only'); 
            }else{
                return $this->response(['user_id' => $result->id], 201, 'success', 'We couldn\'t send you a verification code. If this persists, contact support'); 
            }
           
        } catch (\Throwable $th) {
            return $this->response($th->getMessage(), 500, 'error', 'A server error occurred.');
        }
    }

    public function verifyCode($request)
    {
        try {
            $data = [
                'verify_code' => $request->verify_code,
            ];
            $rules = [
                'verify_code' => 'required|string|max:6'
            ];

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = implode(' ', $validator->errors()->all());
                return $this->response($errors, 409, 'error' ,$errors);
            }
           
            $code = $request->verify_code;
            $user = $this->userModel->where('verif_code', $code)->first();
            if (!$user) {
                return $this->response(null, 404, 'error', 'User with code not found!');
            }
            if ($user->verif_code == $code) {
                if ($user->is_verified == Constants::IS_VERIFIED_USER) {
                    return $this->response(null, 409, 'error', 'User already verified. Login instead');
                }
                //check if code has expired
                $expires_at = Carbon::parse($user->verif_expires_at);
                $verified_at = Carbon::parse(Carbon::now());

                if ($verified_at->greaterThan($expires_at)) {
                    return $this->response(null, 409, 'error', "Oops! The code has expired! A new code has been sent to your phone number {$this->maskPhoneNumber($user->phone)}");
                }

                $user->is_verified = Constants::IS_VERIFIED_USER;
                $user->phone_verified_at = Carbon::now();
                if ($user->save()) {
                    return $this->response(null, 200, 'success', 'Verification successful! Proceed to Login');
                }
            }
            return $this->response(null, 409, 'error', 'Invalid Verification Code');
        } catch (\Throwable $th) {
            return $this->response($th->getMessage(), 500, 'error', 'A server error occurred.');
        }
    }

    public function resendSms($id)
    {
        try {
            
            $user = $this->userModel->find($id);
            if (!$user) {
                return $this->response(null, 404, 'error', 'User not found! Signup instead!');
            }
            $new_code = $this->generateVerificationCode($user->phone);

            $user->verif_code = $new_code;
            $user->verif_expires_at = Carbon::now()->addMinutes(30);

            if ($user->save()) {
                $user->refresh();
                if ($this->sendSms($user) === true) {
                    return $this->response(null, 200, 'success', 'Check your phone number for verification code'); 
                }else{
                    $user->is_verified = Constants::IS_VERIFIED_USER;
                    $user->phone_verified_at = Carbon::now();
                    $user->save();
                    return $this->response(null, 200, 'success', 'Seems our sms engine is having issues! We\'ve automatically verified!'); 
                }
            }

        } catch (\Throwable $th) {
            return $this->response($th->getMessage(), 500, 'error', 'A server error occurred.');
        }
    }

}