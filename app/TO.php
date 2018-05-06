<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TO extends Model
{
    protected $fillable = ['id','status','name','email','contact'];

    protected $table = 't_os';
    public $primaryKey = 'id';
    public $timestamps = true;
}
