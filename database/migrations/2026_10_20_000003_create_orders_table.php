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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary(); // Kode invoice unik seperti JPR-123456
            $table->string('name', 150);
            $table->string('email', 150);
            $table->string('method', 50);
            $table->decimal('total', 12, 2);
            $table->enum('status', ['Pending', 'Diproses', 'Selesai'])->default('Pending');
            $table->json('items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
