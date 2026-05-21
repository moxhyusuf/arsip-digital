<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['nama', 'username', 'password', 'role'])]
#[Hidden(['password'])]

class User extends Authenticatable
{
    use  SoftDeletes;
    protected $table = 'user';

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'id_user');
    }
}
