<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    //
	protected $primaryKey = 'tagID';
	protected $table = 'tags';
    public $timestamps = false;


    public function scopeCheckTags($query, $tagname) {
    	return $query->where('tagName', '=', $tagname);
    }

}
