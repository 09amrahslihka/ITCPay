<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    //
    protected $table = "profile";
    protected $fillable = [
        'id', 'profile_id', 'fname', 'lname', 'mname', 'address_one', 'address_two', 'country', 'city', 'state', 'postal', 'mobile', 'dob', 'nationality', 'timezone'
    ];
    public $timestamps = false;


}
