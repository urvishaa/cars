<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\ShowRoomAdmin;

class StoreAdmin extends Model
{
    use Notifiable;

    public $table = "administrators";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'first_name', 'last_name', 'email','password','isActive','address','description','city','zip','country','phone','image','adminType','remember_token','created_at','updated_at','issubadmin','category'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
    public function getAuthPassword() {
        return bcrypt($this->password);
    }

   
    public static function userexist($name)
    {       
        if(!empty(User::where('username', $name)->get())){
            return User::where('username', $name)->get();
        }
        else{ return "-"; 
            
        }  
    }
}
