<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_prestasi')
                ->constrained('prestasi')
                ->cascadeOnDelete();

            $table->string('file_dokumentasi');
            $table->string('nama_file');
            $table->text('keterangan')->nullable();
            $table->date('tgl_upload');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi');
    }
};
