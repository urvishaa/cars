<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\Orders;
use App\PlaceOrder;
use App\City;
use App\User;

class Orders extends Model
{
    public $timestamps = false;
    public $table = "orders";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'Order_ID';
    protected $fillable = ['Order_ID','User_ID','Status','TotalCount','Name','Mobile','address','city','datetime'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

     public function hasManyPlaceOrder(){
        return $this->hasMany('App\PlaceOrder', 'Order_ID', 'Order_ID');
     }
     public function hasOneCity(){
      return $this->hasOne('App\City', 'id', 'city');
   }
   public function hasOneUser(){
      return $this->hasOne('App\User', 'id', 'User_ID');
   }
   // public function hasManyPlaceOrderDetail(){
   //    return $this->hasMany('App\PlaceOrder', 'Order_ID', 'Order_ID')->where('');
   // }

    
    
}
