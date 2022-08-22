<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['body' ,'from_user','to_user'];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user');
    }
}
