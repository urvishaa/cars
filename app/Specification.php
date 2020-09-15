<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\Specification;


class Specification extends Model
{
    public $timestamps = false;
    public $table = "specification";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','ar','ku','published'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   

    
    
    
}
