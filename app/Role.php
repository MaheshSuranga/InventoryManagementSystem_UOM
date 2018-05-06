<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name','permission'];

    public function users(){
        return $this->belongsToMany(\App\User::class,'role_users');
    }

    public function hasAccess(array $permissions){
        foreach($permissions as $permission){
            if($this->hasPermission($permission)){
                return true;
            }
        }
        return false;
    }

    protected function hasPermission(string $permission){
        $permissions = json_decode($this->permissions, true);
        return $permissions[$permission]??false;
    }
}
