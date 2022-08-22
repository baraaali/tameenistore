<?php

namespace App;

use App\Governorate;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = ['id'];

     /**
     * Get the country that owns the Governorate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

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
