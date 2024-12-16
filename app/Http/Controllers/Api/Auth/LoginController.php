<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Core\CoreUser;
use App\Traits\Core\RandomTokenTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use RandomTokenTrait;

    public function main(Request $request)
    {
        try {
            $field = isset($request->username) ? 'username' : 'email';
            $fieldValue = isset($request->username) ? $request->username : $request->email;
            $user = CoreUser::where($field, $fieldValue)->first();

            if ($user) {
                if ($user->active == 0) {
                    return ApiResponse::error([
                        'code' => 3,
                        'message' => 'User is inactive',
                    ], 403);
                } else {
                    $password = substr($request->password, 11, strlen($request->password) - 18);
                    if (Hash::check($password, $user->password)) {
                        $token = $this->getNewRememberToken(60, 'app_token');
                        $firstLogin = $user->first_login == 1 ? 0 : 0;

                        $data = [
                            'first_login' => $firstLogin,
                            'app_token' => $token,
                        ];

                        if ($request->notification_token) {
                            $data['notification_token'] = $request->notification_token;
                        }

                        CoreUser::where('id', $user->id)->update($data);

                        return ApiResponse::success([
                            'id' => $user->id,
                            'name' => $user->name,
                            'surname' => $user->surname,
                            'userToken' => $token
                        ], 201);
                    } else {
                        return ApiResponse::error([
                            'code' => 2,
                            'message' => 'Wrong username or password',
                        ], 401);
                    }
                }
            } else {
                return ApiResponse::error([
                    'code' => 2,
                    'message' => 'User not found',
                ], 404);
            }
        } catch (Exception $e) {
            return ApiResponse::error([
                'code' => 999,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
