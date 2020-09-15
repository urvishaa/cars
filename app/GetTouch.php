<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\GetTouch;


class GetTouch extends Model
{
    public $timestamps = false;
    public $table = "get_touch";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','value'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    
    
}
