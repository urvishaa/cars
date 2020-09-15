<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\ContactUs;


class ContactUs extends Model
{
    public $timestamps = false;
    public $table = "get_touch";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','description','address','phone','email'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   

    
    
    
}
