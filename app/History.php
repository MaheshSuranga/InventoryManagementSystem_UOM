<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'histories';
    public $primaryKey = 'id';
    public $timestamps = true;
}
