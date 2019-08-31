<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\TweetRequest;
use App\Tweet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Hash;
use Validator;

class TweetController extends Controller
{

    public $successStatus = 200;

    public function init(TweetRequest $request)
    {
        $input = $request->all();
        $success = Tweet::initTweet($input);
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function delete($id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->handleDelete();
        return response()->json(null, 204);
    }
}
