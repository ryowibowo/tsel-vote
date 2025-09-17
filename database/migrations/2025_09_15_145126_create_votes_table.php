<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel ini buat nyimpen setiap pilihan vote
        Schema::create('votes', function (Blueprint $table) {
            $table->id();

            // INI YANG PALING PENTING:
            $table->foreignId('voter_id')->constrained()->onDelete('cascade'); // Penghubung ke tabel voters
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Penghubung ke tabel products

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
};
