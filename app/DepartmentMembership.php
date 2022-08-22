<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DepartmentMembership extends Model
{
    protected $table='departmentmemberships';
    public $timestamps = false;
    protected $fillable=['name_ar','name_en','price','duration','type'];
    public function getName($lang = null)
    {
        if($lang)
        {
          $name = 'name_'.$lang;
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->name_ar  : $this->name_en ;
    } 
}
