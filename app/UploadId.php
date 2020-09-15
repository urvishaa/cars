<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\UploadId;

class UploadId extends Model
{
	public $timestamps = false;

	public $table = "upload_id";
    

    protected $fillable = [
    		'c_agentId',
	        'image',
	    ];
}
