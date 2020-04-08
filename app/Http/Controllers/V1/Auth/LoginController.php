<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendRegisterEmail;
use App\Models\User;
use App\Transformers\AuthorizationTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Authorization;

class LoginController extends Controller
{
    public $loginAfterSignUp = true;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh','register']]);
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->name= $request->name;
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
        if (!$jwt_token = Auth::attempt($input))
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
        $authorization = new Authorization(Auth::refresh());
        return $this->response->item($authorization, new AuthorizationTransformer());
    }

    public function deleteInvalidate()
    {
        \Auth::logout();
        return $this->response->noContent();
    }
}
