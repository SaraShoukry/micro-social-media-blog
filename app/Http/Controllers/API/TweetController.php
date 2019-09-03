<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\TweetRequest;
use App\Tweet;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Validator;

class TweetController extends Controller
{

    /**
     * user create tweet
     *
     * @param TweetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function init(TweetRequest $request)
    {
        $input = $request->all();
        $success = Tweet::initTweet($input);
        return response()->json(['success' => $success], 201);
    }

    /**
     * user delete tweet
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->handleDelete();
        return response()->json(null, 204);
    }
}
