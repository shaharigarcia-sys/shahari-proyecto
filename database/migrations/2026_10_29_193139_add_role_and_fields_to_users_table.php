<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol', 30)->default('usuario')->after('email');
            $table->unsignedTinyInteger('edad')->nullable()->after('rol');
            $table->string('direccion', 255)->nullable()->after('edad');
            $table->string('telefono', 20)->nullable()->after('direccion');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol', 'edad', 'direccion', 'telefono']);
        });
    }
};
