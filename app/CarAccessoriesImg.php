<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\CarAccessoriesImg;


class CarAccessoriesImg extends Model
{
    public $timestamps = false;
    public $table = "car_accessories_img";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id','img_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   

    
    
    
}
