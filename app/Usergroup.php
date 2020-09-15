<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;
use App\User;

class Usergroup extends Model
{
	public $timestamps = false;

	public $table = "usergroups";
    

    protected $fillable = [
    		'id',
          'typeName',
          'parentGroup',
        ];
}
