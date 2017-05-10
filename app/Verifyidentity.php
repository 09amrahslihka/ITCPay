<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verifyidentity extends Model
{

    protected $table = "verificationidentity";

    public $timestamps = false;

    protected $fillable = ['user_id', 'type', 'business_document', 'personal_document'];
}