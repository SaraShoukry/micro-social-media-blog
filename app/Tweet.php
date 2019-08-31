<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Tweet extends Model
{
    protected $table = 'tweets';

    /**
     * Get the user that owns the tweet.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function initTweet($data){
        $tweet =new Tweet();
        $tweet->user_id = Auth::user()->id;
        $tweet->tweet = $data['tweet'];
        $tweet->save();
        return true;
    }

    public function handleDelete()
    {
        $id = $this->id;
        $this->delete();
    }
}
