<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validation;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();
        if ($user->role == 'admin'){
            $input = $request->all();
            $res = User::where('id',"!=", $user->id)
            ->where('status','=',$input['request'])
            ->where('role','!=','guest')
            ->get();
            // $res = DB::table('users')
            // ->select('*')
            // ->where('id',"!=", $user->id)
            // ->where('status','=',$input['request'])
            // ->where('role','!=','guest')
            // ->get();
            return $this->sendResponse($res, 'User List.');
        }else{
            return $this->sendError('Unauthorised.', ['error' => 'Your not allowed for this operation!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->sendResponse($user, 'User Details.');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user1 = auth('api')->user();
        if ($user1->role == 'admin') {
            return $this->sendResponse(User::all()->where('id', "!=", $user1->id), 'User List.');
        } else {
            $input = $request->all();
            $input['status'] = $input['status'];
            $user->update($input);
            return $this->sendResponse($user, 'User Updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user1 = auth('api')->user();
        if ($user1->role == 'admin') {
            $user->delete();
            return $this->sendResponse($user, 'user deleted successfully!.');
        }
    }

    public function deactivate(User $user)
    {
        $role = auth('api')->user()->role;
        if ($role == 'admin'){
            $user->update(['status' => 'deactivated']);
            return $this->sendResponse('Success', 'User has been deactivated successfully.');
        }else{
            return $this->sendError('Unauthorised.', ['error' => 'Your not allowed for this operation!']);
        }
    }
    public function activate(User $user)
    {
        $role = auth('api')->user()->role;
        if ($role == 'admin'){
            $user->update(['status' => 'active']);
            return $this->sendResponse('Success', 'User has been activated successfully.');
        }else{
            return $this->sendError('Unauthorised.', ['error' => 'Your not allowed for this operation!']);
        }
    }
}
