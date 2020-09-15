<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\Country;

class Country extends Model
{
	public $timestamps = false;

	public $table = "countries";
    

    protected $fillable = [
    		'countries_id',
            'countries_name',
            'countries_iso_code_2',
	        'countries_iso_code_3',
	        'address_format_id',
	    ];
}
