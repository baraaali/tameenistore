<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $guarded = ['id'];

    public function getCreatedAtAttribute($date)
    {
     return date_format(new DateTime($date),'d-m-Y H:i:s');
    }
}
