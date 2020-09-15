<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\TopCar;

class TopCar extends Model
{
	public $timestamps = false;

	public $table = "top_car";
    

    protected $fillable = [
    		'carId',
	        'fromdate',
	        'todate',
	        'date',
	    ];
}
