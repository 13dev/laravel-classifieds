<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemImages extends Model
{
	protected $table 	= 'items_images';
	protected $fillable = [
	'item_id', 'path', 'created_at','updated_at',
	];
	public function item()
	{
		return $this->belongsTo('App\Item');
	}
}
