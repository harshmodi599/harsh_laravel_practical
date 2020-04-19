<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model{
    protected $fillable = [
        'user_id','user_name','first_name','last_name','email','mobile','gender','photo'
    ];
}
