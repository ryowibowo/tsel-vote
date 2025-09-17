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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Ini kunci relasinya, bre. Setiap produk PASTI punya satu kategori.
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            // Diubah dari icon jadi image, dan bisa kosong (nullable)
            $table->string('image')->nullable();
            $table->integer('votes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
