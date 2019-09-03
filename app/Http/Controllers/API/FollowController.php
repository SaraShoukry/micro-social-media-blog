<?php

namespace App\Http\Controllers\API;

use App\Follower;
use App\Http\Requests\FollowRequest;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{

    /**
     * user follow another user
     *
     * @param FollowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function init(FollowRequest $request)
    {
        $data = $request->all();
        $success = Follower::follow($data);
        return response()->json(['success' => $success], 201);
    }
}
