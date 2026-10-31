<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_user')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nama', 150);
            $table->string('username', 50)->unique();
            $table->string('email')->unique();
            $table->string('no_hp', 20)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
