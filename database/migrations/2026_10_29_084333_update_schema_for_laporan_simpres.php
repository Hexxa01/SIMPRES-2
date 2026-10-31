<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 30)->default('mahasiswa')->change();
            $table->string('fakultas', 100)->nullable()->default('Fakultas Sains dan Teknologi')->after('prodi');
            $table->string('gender', 20)->nullable()->after('foto_profil');
        });

        Schema::table('prestasi', function (Blueprint $table) {
            $table->string('jenis_prestasi', 50)->change();
            $table->string('tingkat_prestasi', 50)->change();
            $table->unsignedSmallInteger('tahun_penyelenggaraan')->nullable()->after('tahun_perolehan');
        });

        if (! Schema::hasTable('pimpinans')) {
            Schema::create('pimpinans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_user')
                    ->unique()
                    ->constrained('users')
                    ->cascadeOnDelete();
                $table->string('nama', 150);
                $table->string('username', 50)->unique();
                $table->string('email')->unique();
                $table->string('no_hp', 30)->nullable();
                $table->string('jabatan', 100)->nullable()->default('Dekan / Pimpinan Fakultas');
                $table->string('gender', 20)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pimpinans');

        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn(['tahun_penyelenggaraan']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['fakultas', 'gender']);
        });
    }
};
