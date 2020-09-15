<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\City;


class City extends Model
{
    public $timestamps = false;
    public $table = "city";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','ar','ku'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   
    
}
