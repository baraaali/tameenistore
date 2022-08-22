<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class country extends Model
{
    protected $table='countries';
    protected $fillable=['parent','en_name','ar_name','en_code','ar_code','status','image'];
    use SoftDeletes;
    public function getName($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_name';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_name  : $this->en_name ;
    } 
    public function getCurrency($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_currency';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_currency  : $this->en_currency ;
    } 
    public function owner()
    {
        return $this->belongsTo('App\country', 'parent')->select('en_name');
    }

    public function children()
    {
        return $this->hasMany('App\country', 'parent');

    }

}
