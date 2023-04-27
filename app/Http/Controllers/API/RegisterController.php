<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Validation\Validator;
use Validator;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['status'] = 'active';
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->firstname . ' ' . $user->lastname;
        $success['imagesrc'] = $user->imagesrc;
        $success['role'] = $user->role;

        $nFor = 'admin';
        $ntype = 'New User';
        $nmsg = 'A new user ' . $success['name'] . ' has successfully registered an account!';
        $nid = $user->id;
        $this->addToNotification($nFor, $ntype, $nmsg, $nid);

        return $this->sendResponse($success, 'User register successfully.');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->rememberme)) {

            //$user = Auth::user();
            $user = User::where('email', $request->email)->first();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->firstname . ' ' . $user->lastname;
            $success['imagesrc'] = $user->imagesrc;
            $success['role'] = $user->role;

            if ($user->status == 'deactivated') {
                return $this->sendError('Unauthorised.', ['error' => 'Your account has been deactivated. Please contact the administrator!']);
            }
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'The email and password is not found in the system!']);
        }
    }
    public function check()
    {
        return $this->sendResponse('', 'User is loged.');
    }

    public function mydetails()
    {
        return $this->sendResponse(auth('api')->user(), 'Your details.');
    }

    public function updateaccount(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $user->update($input);

        return $this->sendResponse('', 'User updated successfully.');
    }

    public function changepassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password'
        ]);

        $input2 = $request->all();
        //echo json_encode($request->all());
        //return $this->sendError('', ['old' => auth('api')->user()->getAuthPassword(), 'new' => bcrypt($input2['password'])]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $email = auth('api')->user()->email;
        $pass = $request->password;
        $check = User::where([['email', '=', $email ]])->first();
        $hashcheck = Hash::check($pass, $check->password);
        if ($hashcheck) {

            $input['password'] = bcrypt($input2['new_password']);

            $user->update($input);

            return $this->sendResponse('', 'Password changed successfully.');

        } else {
             return $this->sendError('Wrong password.', [
                'password' => ['Invalid password!'],
                'email' => [auth('api')->user()->email],
                'pass' => [$request->password],
                'hash' => [bcrypt($request->password)],
                'count' => [$check]
            ]);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return $this->sendResponse('', 'Logout');
    }
}
