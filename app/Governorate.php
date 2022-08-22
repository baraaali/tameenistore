<?php

namespace App;

use App\country;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $guarded = ['id'];


    /**
     * Get the country that owns the Governorate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function getName($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_name';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_name  : $this->en_name ;
    } 
    public function country()
    {
        return $this->belongsTo(country::class, 'country_id');
    }
}
