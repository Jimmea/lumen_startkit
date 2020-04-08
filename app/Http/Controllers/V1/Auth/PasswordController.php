<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 1/16/19
 * Time: 23:59
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function edit(Request $request)
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

        $user->password = $password;
        $user->save();
        return $this->response->noContent();
    }

    public function reset()
    {

    }
}