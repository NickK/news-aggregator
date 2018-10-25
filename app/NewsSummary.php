<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsSummary extends Model
{
    //
	protected $primaryKey = 'nsummaryID';
	protected $table = 'newsSummary';

    public function tags() {
    	return $this->hasOne('\App\Tags', 'tagID', 'tagID');
    }


}
