<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompleteDocSubmit extends Model
{
    protected $table = 'complete_doc_submit';
    protected $fillable = ['complete_doc_id' ,'owner_id', 'user_id','price','status','net_price','file','start_date'];
    protected $hidden=['created_at','updated_at'];

    public function complete_doc()
    {
        return $this->belongsTo('App\CompleteDoc');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function CompleteDocSubmitAddition()
    {
        return $this->hasMany('App\CompleteDocSubmitAddition','complete_doc_submit_id','id');
    }

}
