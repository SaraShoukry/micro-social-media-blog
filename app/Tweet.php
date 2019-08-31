<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
