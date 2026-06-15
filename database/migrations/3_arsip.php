<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('user', 'id');
            $table->foreignId('id_kategori')->constrained('kategori', 'id');
            $table->string('no_registrasi')->unique()->nullable();
            $table->string('nama');
            $table->string('deskripsi');
            $table->string('file');
            $table->date('tanggal_retensi')->nullable();
            $table->enum('status_retensi', ['permanen', 'sementara', 'dimusnahkan (Srikandi)'])->default('permanen');
            $table->enum('status_validasi', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->string('pesan_penolakan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};
