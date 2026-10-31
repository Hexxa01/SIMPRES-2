<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Hasil/perolehan prestasi (juara / partisipasi) - laporan hal. 2 & 3
            $table->string('perolehan', 30)->nullable()->after('tingkat_prestasi');

            // Informasi pendukung / deskripsi (atribut "deskripsi" pada ERD)
            $table->text('deskripsi')->nullable()->after('tempat_pelaksanaan');

            // Relasi "diverifikasi" Admin -> Prestasi pada ERD
            $table->foreignId('id_admin')
                ->nullable()
                ->after('catatan_revisi')
                ->constrained('admins')
                ->nullOnDelete();

            $table->timestamp('diverifikasi_pada')->nullable()->after('id_admin');

            $table->index('perolehan');
        });
    }

    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['id_admin']);
            $table->dropIndex(['perolehan']);
            $table->dropColumn([
                'perolehan',
                'deskripsi',
                'id_admin',
                'diverifikasi_pada',
            ]);
        });
    }
};
