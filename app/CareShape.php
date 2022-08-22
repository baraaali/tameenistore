<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CareShape extends Model
{
    protected $guarded = ['id'];


    public function getName($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_name';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_name  : $this->en_name ;
    }
}

