<?php

namespace App;

use App\DepartmentMembership;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class items extends Model
{
	use SoftDeletes;

	protected $table = 'items';
    protected $guarded = ['id'];


	//protected $fillable=['visitors'];
    public function getName($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_name';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_name  : $this->en_name ;
    } 

     public function category()
    {
    	return $this->belongsTo(Categories::class);
    }

    public function images(){
        return $this->hasMany('\App\item_pics','item_id','id');
    }

    public function country(){
        return $this->hasOne(country::class,'id','country_id');
    }
    public function user(){
        return $this->hasOne('\App\User','id','user_id');
    }
    public function membership(){
        return $this->belongsTo(DepartmentMembership::class,'special');
    }
}

