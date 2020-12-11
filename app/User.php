<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'right_id', 'instrument_id', 'approved_at', 'profile_picture',
        'public_events_notifications', 'band_events_notifications', 'group_events_notifications',
        'public_posts_notifications', 'band_posts_notifications', 'group_posts_notifications'
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

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function right(){
        return $this->belongsTo('App\Right');
    }

    public function instrument(){
        return $this->belongsTo('App\Instrument');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function events(){
        return $this->belongsToMany('App\Event', 'event_users');
    }

}

