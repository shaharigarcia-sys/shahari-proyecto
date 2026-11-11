<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('cliente_nombre', 120);
            $table->string('cliente_correo', 150);
            $table->string('cliente_telefono', 20);
            $table->string('direccion_entrega', 255);
            $table->decimal('total', 10, 2);
            $table->unsignedInteger('total_productos');
            $table->string('estado', 30)->default('completado');
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('nombre_producto', 160);
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('cantidad');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
    }
};
