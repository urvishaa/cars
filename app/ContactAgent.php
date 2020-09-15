<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\ContactAgent;
use App\DriverLicense;
use App\UploadId;
use App\Car;
use App\Country;

class ContactAgent extends Model
{
    public $timestamps = false;
    public $table = "contact_agent";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['carId','userId','user_type','firstName','lastName','nationality','email','phone','dateFrom','dateTo','stauts'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function hasManyLicense(){
        return $this->hasMany('App\DriverLicense', 'c_agentId', 'id');
    }
    public function hasManyUploadId(){
        return $this->hasMany('App\UploadId', 'c_agentId', 'id');
    }
    public function hasOneCar(){
      return $this->hasOne('App\Car', 'id', 'carId');
    }
    public function hasOneCountry(){
        return $this->hasOne('App\Country', 'countries_id', 'nationality');
    }

    public function hasManyCarimage(){
        return $this->hasMany('App\Car_img', 'car_id', 'carId');
    }

    
    
    
}
