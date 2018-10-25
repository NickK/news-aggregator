<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSourcesRel extends Model
{
    //
	protected $primaryKey = 'userSourcesRelID';
	protected $table = 'userSourcesRel';
    public $timestamps = false;


    public function sources() {
    	return $this->hasOne('\App\NewsSummary', 'sourceID', 'sourceID');
    }

}
