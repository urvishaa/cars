<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\Car;
use App\Car_img;
use App\CarModel;
use App\City;


class Car extends Model
{
    public $table = "car";

    public $timestamps = false;    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'car_name','address','city','sale_price','weekly_rentprice','daily_rentprice','month_rentprice','description','car_brand','kilometer','year_of_car','fueltype','pro_type','prop_category','googleLocation','lat','lng','userType','userId','showRoomId','companyId','email','phone','published','video','gear_type'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   

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

    public function hasManyCarImage(){
        return $this->hasMany('App\Car_img', 'car_id', 'id');
    }
    public function hasOneCarBrand(){
        return $this->hasOne('App\CarBrand', 'id', 'car_brand');
    }
    public function hasOneCarModel(){
        return $this->hasOne('App\CarModel', 'id', 'prop_category');
    }
    public function hasOneCarCity(){
        return $this->hasOne('App\City', 'id', 'city');
    }
    
}
