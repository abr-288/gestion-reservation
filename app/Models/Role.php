<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    public function users()
        {
         return $this->belongsToMany(User::class);
        }
}
class User extends Authenticatable
{
    use HasRoles;
    // ...
}