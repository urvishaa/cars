<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\Price;


class Price extends Model
{
    public $timestamps = false;
    public $table = "price";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['price','name'];

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
