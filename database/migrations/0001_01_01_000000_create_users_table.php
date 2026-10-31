<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('nim', 30)->nullable()->unique();
            $table->string('username', 50)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_hp', 20)->nullable();
            $table->string('prodi', 100)->nullable();
            $table->unsignedSmallInteger('angkatan')->nullable();
            $table->string('foto_profil')->nullable();
            $table->enum('role', ['mahasiswa', 'admin'])
                ->default('mahasiswa');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
