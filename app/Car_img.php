<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\Car_img;

class Car_img extends Model
{
	public $timestamps = false;

	public $table = "car_img";
    

    protected $fillable = [
    		'car_id',
	        'img_name',
	    ];
}
