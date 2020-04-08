<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/1/19
 * Time: 18:38
 */

namespace App\Http\Controllers\V1;
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Transformers\UserTransformer;

class UserController extends BaseController
{
    public function index()
    {
        $users = User::paginate();
        return $this->response->paginator($users, new UserTransformer());
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->response->item($user, new UserTransformer());
    }

    public function userShow()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }
}