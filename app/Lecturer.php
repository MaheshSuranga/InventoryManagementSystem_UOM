<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = ['id','status','designation','name','email','contact'];

    protected $table = 'lecturers';
    public $primaryKey = 'id';
    public $timestamps = true;
}
