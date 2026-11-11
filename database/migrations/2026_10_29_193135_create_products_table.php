<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 160);
            $table->string('marca', 80);
            $table->string('categoria', 80)->default('Agua');
            $table->string('presentacion', 60);
            $table->string('unidad', 40)->default('Desde');
            $table->decimal('precio', 10, 2);
            $table->string('imagen', 255)->default('producto-default.svg');
            $table->string('etiqueta', 40)->nullable();
            $table->boolean('retornable')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
