<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\CarModel;
use App\CarBrand;


class CarModel extends Model
{
    public $timestamps = false;
    public $table = "car_model";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','ar','ku','car_brand_id','published'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   
    public function hasOneCarBrand(){
        return $this->hasOne('App\CarBrand', 'id', 'car_brand_id');
     }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getAuthIdentifier() {
        return $this->getKey();
    }
    
    
}
