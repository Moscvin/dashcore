<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Mail\Core\Auth\ResetPasswordMail;
use App\Models\Core\CoreAdminOption;
use App\Models\Core\CoreUser;
use App\Traits\Core\RandomTokenTrait;
use Illuminate\Http\Request;

class RetrievePasswordController extends Controller
{
    use RandomTokenTrait;

    public function main(Request $request)
    {
        try {
            $user = CoreUser::where('email', $request->email)->first();

            if (!$user) {
                return ApiResponse::error([
                    'code' => 2,
                    'message' => 'User not found',
                ], 401);
            } else {

                if (!$user->active) {
                    return ApiResponse::error([
                        'code' => 3,
                        'message' => 'User is not active',
                    ], 401);
                } else {
                    $password = $this->getNewRememberToken(8, 'password');
                    $password_hash = bcrypt($password);

                    $user->update([
                        'password' => $password_hash,
                    ]);

                    \Mail::to($user->email)->send(new ResetPasswordMail($user, CoreAdminOption::getPlucked(), $password));

                    return ApiResponse::success([], 204);
                }

            }
        } catch (\Throwable$e) {
            return ApiResponse::error([
                'code' => 999,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
