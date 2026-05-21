<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['nama', 'keterangan',])]
#[Hidden([])]

class Kategori extends Model
{
    use  SoftDeletes;

    protected $table = 'kategori';

    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'id_kategori');
    }
}
