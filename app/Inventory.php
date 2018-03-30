<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';
    public $primaryKey = 'id';
    public $timestamps = true;
    //
}
