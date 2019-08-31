<?php

namespace App\Http\Controllers\API;

use App\Follower;
use App\Http\Requests\FollowRequest;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{

    public $successStatus = 200;

    public function init(FollowRequest $request)
    {
        $data = $request->all();
        $success = Follower::follow($data);
        return response()->json(['success' => $success], $this->successStatus);
    }

    /*public function delete($id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->handleDelete();
        return response()->json(null, 204);
    }*/
}
