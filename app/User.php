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
        'name', 'email', 'password', 'profile_image'
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
     * get profile picture
     * @return mixed
     */
    public function getProfilePictureAttribute()
    {
        return $this->profile_picture;
    }

    /**
     * register
     *
     * @param $data
     * @return mixed
     */
    public function register($data){
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
    public function setAPIToken($api_token){
        $this->api_token = $api_token;
        return $this->save();
    }
}
