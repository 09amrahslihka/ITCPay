<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemVariable extends Model
{
    protected $table = "system_variable";
    protected $fillable = array('key', 'value');
    public $timestamps = false;

}
