<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTagsRel extends Model
{
    //
	protected $primaryKey = 'userTagRelID';
	protected $table = 'userTagsRel';
    public $timestamps = false;

    public function tag() {
    	return $this->hasOne('\App\Tags', 'tagID', 'tagID');
    }

}
