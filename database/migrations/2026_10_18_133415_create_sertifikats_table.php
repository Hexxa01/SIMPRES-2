<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_prestasi')
                ->constrained('prestasi')
                ->cascadeOnDelete();

            $table->string('file_sertifikat');
            $table->string('nama_file');
            $table->date('tgl_upload');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
