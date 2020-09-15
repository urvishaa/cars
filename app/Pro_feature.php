<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\Pro_feature;

class Pro_feature extends Model
{
	public $timestamps = false;

	public $table = "pro_feature";
    

    protected $fillable = [
    		'pro_id',
	        'feature_id',
	    ];
}
