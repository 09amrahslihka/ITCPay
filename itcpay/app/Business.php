<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{

    protected $table = "business";
    protected $fillable = [
        'id', 'user_id', 'name', 'address_one', 'address_two', 'country', 'city', 'state', 'postal'
    ];
    public $timestamps = false;

}
