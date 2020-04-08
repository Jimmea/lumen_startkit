<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\BaseController;
use App\Jobs\SendRegisterEmail;
use App\Models\Authorization;
use App\Models\User;
use App\Transformers\AuthorizationTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    public $loginAfterSignUp = true;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh','register']]);
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if ($this->loginAfterSignUp)
        {
            return $this->login($request);
        }

        dispatch(new SendRegisterEmail($user));

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input))
        {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        $authorization = new Authorization($jwt_token);
        return $this->response->item($authorization, new AuthorizationTransformer())
            ->setStatusCode(201);
    }

    public function refresh()
    {
        $authorization = new Authorization(\Auth::refresh());
        return $this->response->item($authorization, new AuthorizationTransformer());
    }

    /**
     * Lấy thông tin theo token
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getAuthUser(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json(['user' => $user]);
    }

    public function editPassword(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|different:old_password',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails())
        {
            return $this->errorBadRequest($validator);
        }

        $user = $this->user();
        $auth = \Auth::once([
            'email' => $user->email,
            'password' => $request->get('old_password'),
        ]);

        if (!$auth)
        {
            return $this->response->errorUnauthorized();
        }
        $password = app('hash')
                    ->make($request->get('password'));

        $user->update(['password' => $password]);

        return $this->response->noContent();
    }

    /**
     * Cập nhật thông tin
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function patch(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'name' => 'required|string|max:50',
            'avatar' => 'url',
        ]);

        if ($validator->fails())
        {
            return $this->errorBadRequest($validator);
        }

        $user = $this->user();
        $attributes = array_filter($request->only('name', 'avatar'));
        if ($attributes)
        {
            $user->update($attributes);
        }
        return $this->response->item($user, new UserTransformer());
    }

    public function deleteInvalidate()
    {
        \Auth::logout();
        return $this->response->noContent();
    }
}
