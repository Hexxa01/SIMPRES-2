<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_mahasiswa')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nama_prestasi', 200);

            $table->enum('jenis_prestasi', [
                'akademik',
                'non-akademik',
            ]);

            $table->enum('tingkat_prestasi', [
                'lokal',
                'nasional',
                'internasional',
            ]);

            $table->unsignedSmallInteger('tahun_perolehan');
            $table->string('penyelenggara', 200);
            $table->string('tempat_pelaksanaan', 200)->nullable();

            $table->enum('status_verifikasi', [
                'menunggu',
                'terverifikasi',
                'ditolak',
                'perlu_perbaikan',
            ])->default('menunggu');

            $table->decimal('skor', 5, 2)->nullable();
            $table->text('catatan_revisi')->nullable();

            $table->timestamps();

            $table->index([
                'status_verifikasi',
                'tahun_perolehan',
            ]);

            $table->index([
                'jenis_prestasi',
                'tingkat_prestasi',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
