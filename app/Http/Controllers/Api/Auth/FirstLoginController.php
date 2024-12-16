<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Responses\ApiResponse;
use App\Mail\Core\Auth\FirstLoginMail;
use App\Models\Core\CoreUser;
use App\Traits\Core\RandomTokenTrait;
use Illuminate\Http\Request;

class FirstLoginController
{
    use RandomTokenTrait;

    public function main(Request $request)
    {
        try {
            $email = $request->email;
            if (empty(CoreUser::where('email', $email)->first())) {
                $response = [
                    'error_code' => 2,
                ];
                return ApiResponse::error($response, 401);
            } elseif (!CoreUser::where('email', $email)->first()->first_login) {
                $response = [
                    'error_code' => 3,
                ];
                return ApiResponse::error($response, 403);
            } elseif (!CoreUser::where('email', $email)->first()->active) {
                $response = [
                    'error_code' => 4,
                ];
                return ApiResponse::error($response, 403);
            } else {
                $password = $this->getNewRememberToken(8, 'password');
                $password_hash = bcrypt($password);

                $change_pswd = CoreUser::where('email', $email)->update([
                    'password' => $password_hash,
                    'first_login' => 0,
                ]);

                if ($change_pswd) {
                    $user = CoreUser::where('email', $email)->first();
                    \Mail::to($user->email)->send(new FirstLoginMail($user, $password));
                    return ApiResponse::success([], 204);
                }
            }
        } catch (\Exception$e) {
            $response = [
                'status' => 'error',
                'data' => [
                    'error_code' => 999,
                    'error_message' => $e->getMessage(),
                ],
            ];
            return response()->json($response, 500);
        }
    }
}
