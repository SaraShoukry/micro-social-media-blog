<?php

namespace App;

use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use UploadTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the tweets for the user.
     */
    public function tweets()
    {
        return $this->hasMany('App\Tweet');
    }


    /**
     * Get the followers for the user.
     */
    /**
     * Get the followers for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * Get the users followed by this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * register
     *
     * @param $data
     * @return mixed
     */

    public function register($data)
    {
        //upload image
        $profileImage = $data['profile_picture'];
        $profileImageSaveAsName = time() . "-profile." . $profileImage->getClientOriginalExtension();
        $upload_path = 'profile_images/';
        $profile_image_url = $upload_path . $profileImageSaveAsName;
        $this->uploadOne($profileImage, $upload_path, 'public', $profileImageSaveAsName);

        $data['profile_picture'] = $profile_image_url;
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $success['token'] = $user->createToken('MyApp')->accessToken;

        $user->api_token = $success['token'];
        $user->save();
        return $user;
    }

    /**
     * @param $api_token
     * @return bool
     */

    public function setAPIToken($api_token)
    {
        $this->api_token = $api_token;
        return $this->save();
    }

    public function timeline()
    {
        $followers_ids = $this->followers()->pluck('follower_id')->toArray();
        $tweets = Tweet::whereIn('user_id', $followers_ids)->paginate();
        return $tweets;
    }
}
