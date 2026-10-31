<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_user')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('id_prestasi')
                ->nullable()
                ->constrained('prestasi')
                ->cascadeOnDelete();

            $table->string('judul', 150);
            $table->text('pesan');
            $table->timestamp('dibaca_pada')->nullable();

            $table->timestamps();

            $table->index(['id_user', 'dibaca_pada']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
