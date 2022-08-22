<?php

namespace App;
use App\City;
use App\Mcenters;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phones','type','country_id','notifications_balance'
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

    public function Country(){
        return $this->hasOne('\App\country','id','country_id');
    }
    public function city(){
        return $this->hasOne(City::class,'id','city_id');
    }
    public function governorate(){
        return $this->hasOne(Governorate::class,'id','governorate_id');
    }


//    public function orders(){
//        return $this->hasOne('\App\Booking','user_id','id');
//    }

      public function userDocs(){
        return $this->hasOne(DocumentsUser::class);
      }

    public function agentDetails(){
        return $this->hasOne(Agents::class);
    }

    public function balance(){
        return $this->hasOne(Balance::class);
    }

    public function tokens(){
        return $this->hasMany(Token::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
   
  
    public function mcenter()
    {
        return $this->hasOne(Mcenters::class, 'user_id');
    }
}
