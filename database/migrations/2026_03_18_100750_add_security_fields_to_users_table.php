<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // Añadir campos de seguridad a la tabla de usuarios ya existente
    Schema::table('users', function (Blueprint $table) {
        $table->integer('login_attempts')->default(0)->after('password');
        $table->boolean('is_blocked')->default(false)->after('login_attempts');

    });

    // Crear la tabla de Bitácora
    Schema::create('bitacoras', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('accion');
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
