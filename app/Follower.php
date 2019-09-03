<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Follower extends Model
{
    protected $table = 'followers';


    public static function follow($data){
        $follow =new Follower();
        $follow->user_id = Auth::user()->id;
        $follow->follower_id = $data['follower_id'];
        $follow->save();
        return true;
    }
}
