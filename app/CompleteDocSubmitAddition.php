<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompleteDocSubmitAddition extends Model
{
    protected $table = 'complete_doc_submit_additions';
    protected $fillable = ['complete_doc_submit_id','addition_id'];
    protected $hidden=['created_at','updated_at'];

    public function addition()
    {
        return $this->belongsTo('App\Addition','addition_id','id');
    }
}
