<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\CarAccessories;


class CarAccessories extends Model
{
    public $timestamps = false;
    public $table = "car_accessories";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id','category_id','name','price','specification','description','size','model','color','status','quantity'];

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
    
    
}
