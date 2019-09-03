<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Hash;
use Validator;

class UserController extends Controller
{

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', request('email'))->first();
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $user->setAPIToken($success['token']);
            return response()->json(['success' => $success], 200);
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
        return response()->json(['success' => $success], 201);
    }

    /**
     * logout api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 204);
    }

    /**
     * auth user timeline
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function timeLine()
    {
        return response()->json([
            'tweets' => Auth::user()->timeline()
        ], 206);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
    }
}
