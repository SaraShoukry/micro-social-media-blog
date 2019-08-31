<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Hash;
use Validator;

class UserController extends Controller
{

    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', request('email'))->first();
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
//            if (Hash::check(request('password'), $user->password)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $user->setAPIToken($success['token']);
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * RegisterRequest api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $user = new User();
        $user = $user->register($input);
        $success['name'] = $user->name;
        $success['token'] = $user->api_token;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function logout(Request $request)
    {

        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        return response()->json($request->user());

        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
