<?php

namespace App\Services;

use App\Constants;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\Utils;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class VerificationService 
{
    use ApiResponse, Utils;

    public User $userModel;
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function verifyCode($request): JsonResponse
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
                    if ($verified_at->greaterThan($expires_at)) {
                        if ($this->sendSms($user) === true) {
                            return $this->response(null, 200, 'success', 'Oops! Code has already expired. Check your phone number for new verification code'); 
                        }else{
                            return $this->response(null, 200, 'success', 'Oops! Code has already expired. Seems sendchamp our sms engine is having issues! Use '.$user->verif_code.' for test purposes only'); 
                        }
                    }
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

    public function resendSms($id): JsonResponse
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
                    return $this->response(null, 200, 'success', 'Seems sendchamp our sms engine is having issues! Use '.$user->verif_code.' for test purposes only'); 
                }
            }

        } catch (\Throwable $th) {
            return $this->response($th->getMessage(), 500, 'error', 'A server error occurred.');
        }
    }
}