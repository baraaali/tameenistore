<?php

namespace App;

use DateTime;
use App\Store;
use App\ServiceCategory;
use App\RangeTimeMcenter;
use App\ServiceMemberShip;
use App\MaintenanceRequest;
use App\ServiceSubCategory;
use App\ServiceChildCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mcenters extends Model
{
	use SoftDeletes;
	protected $guarded = ['id'];

	public static function boot()
    {
        parent::boot();
        self::created(function($model){
            $date =  strtotime($model->created_at. ' + '.$model->serviceMemberShip->months_number.' Month');
			$model->renewal_at =  Date('Y-m-d',$date);
			$model->save();
        });

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
	public function getDescription($lang = null)
    {
        if($lang)
        {
          $name = $lang.'_description';
          return $this->$name;
        }
        return app()->getLocale() == 'ar' ? $this->ar_description  : $this->en_description ;
    }
      public function country()
	    {
	    	return $this->belongsTo(country::class);
	    }

	    public function owner()
	    {
	    	return $this->hasOne('\App\User','id','user_id');
	    }

		public function getCategory()
		{
			$child_category  = ServiceChildCategory::where('id',$this->child_category)->get()->first();
			$sub_category = ServiceSubCategory::where('id',$this->sub_category)->get()->first();
			$category   = ServiceCategory::where('id',$this->category)->get()->first();
			if(!is_null($this->child_category) && !is_null($child_category))
			 return $child_category->getName();
			if(!is_null($this->sub_category) && !is_null($sub_category))
			 return $sub_category->getName();
			if(!is_null($this->category) && !is_null($category))
			 return $category->getName();  
		}
		public function getServiceMemberShips()
		{
			return ServiceMemberShip::where('category',$this->category)
			->where('sub_category',$this->sub_category)
			->where('child_category',$this->child_category)
			->get();
	
		}

		public function getStore()
		{
			return $this->belongsTo(Store::class,'store');
		}	
		public function serviceMemberShip()
		{
			return $this->belongsTo(ServiceMemberShip::class,'special');
		}

		public function getServices()
		{
			return McenterService::where('mcenter_id',$this->id)->get();
		}

		public function services()
		{
			return $this->hasMany(McenterService::class, 'mcenter_id');
		}

		public function times()
		{
			return $this->hasMany(RangeTimeMcenter::class, 'mcenter_id', 'id');
		}

		public function getRating()
		{
			$ratingResults = 0;
			$requestsIds = MaintenanceRequest::where('mcenter_id',$this->id)->get()->pluck('id');
			$rates = McenterRate::whereIn('maintenance_request_id',$requestsIds)->get();
			foreach ($rates as $rate) {
				$ratingResults += $rate->getRateResults();
			}
			return $ratingResults;
		}

		
}
