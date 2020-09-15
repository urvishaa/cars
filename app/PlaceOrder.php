<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\PlaceOrder;
use App\CarAccessoriesImg;


class PlaceOrder extends Model
{
    public $timestamps = false;
    public $table = "Place_Order";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['Place_Order_ID','User_ID','Product_ID','Name','Price','Quantity'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function hasOneProduct(){
        return $this->hasOne('App\CarAccessories', 'id', 'Product_ID');
     }
     public function hasManyPlaceOrder(){
        return $this->hasMany('App\PlaceOrder', 'Order_ID', 'Order_ID');
     }
     public function hasManyProductImg(){
        return $this->hasMany('App\CarAccessoriesImg','product_id', 'Product_ID');
     }
}
