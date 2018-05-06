<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = ['id','status','name','email','contact'];

    protected $table = 'supervisors';
    public $primaryKey = 'id';
    public $timestamps = true;
}
