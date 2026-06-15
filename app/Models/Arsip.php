<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['id_user', 'id_kategori', 'kode', 'nama', 'deskripsi', 'file', 'tanggal_retensi', 'status_retensi', 'status_validasi', 'is_encrypted', 'pesan_penolakan'])]
#[Hidden([])]

class Arsip extends Model
{
    use  SoftDeletes;
    protected $table = 'arsip';

    protected function casts(): array
    {
        return [
            'tanggal_retensi' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
