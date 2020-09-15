<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\DriverLicense;

class DriverLicense extends Model
{
	public $timestamps = false;

	public $table = "driverLicense";
    

    protected $fillable = [
    		'c_agentId',
	        'license',
	    ];
}
