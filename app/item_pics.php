<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class item_pics extends Model
{
	use SoftDeletes;
	
	protected $table = 'items_pics';
	


}
