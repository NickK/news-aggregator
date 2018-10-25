<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SourceLinks extends Model
{
	protected $primaryKey = 'sourceLinksID';
	protected $table = 'sourceLinks';

    protected $dates = [
        'sourceDate'
    ];

    //
    public function sources() {
    	return $this->hasOne('\App\Sources', 'sourceID', 'sourceID');
    }

    public static function userFeed() {
    	return self::with('sources')->where('active', '=', 1)->orderBy('sourceDate', 'DESC');
    }

}
