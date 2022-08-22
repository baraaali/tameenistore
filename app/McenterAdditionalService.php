<?php

namespace App;

use App\McenterService;
use Illuminate\Database\Eloquent\Model;

class McenterAdditionalService extends Model
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
   public function getDescription($lang = null)
  {
      if($lang)
      {
        $name = $lang.'_description';
        return $this->$name;
      }
      return app()->getLocale() == 'ar' ? $this->ar_description  : $this->en_description ;
  }
 
  public function service()
  {
      return $this->belongsTo(McenterService::class, 'mcenter_service_id');
  }
}
