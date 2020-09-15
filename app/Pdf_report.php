<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\Pdf_report;

class Pdf_report extends Model
{
	public $timestamps = false;

	public $table = "pdf_report";
    

    protected $fillable = [
    		'pro_name',
	        'pdf_upload',
	    ];
}
