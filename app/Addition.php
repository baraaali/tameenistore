<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addition extends Model
{
    protected $table = 'additions';
    protected $hidden=['created_at','updated_at'];
    protected $fillable = ['FeatureNameAr' , 'FeatureNameEn' , 'FeatureCost','FeatureNotices' , 'insurance_document_id'];
}
