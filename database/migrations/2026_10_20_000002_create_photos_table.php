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
        Schema::create('photos', function (Blueprint $table) {
            $table->id('photo_id')->autoIncrement();
            $table->string('title', 150);
            $table->string('slug', 255)->unique();
            $table->foreignId('category_id');
            $table->string('photographer', 150)->default('I Made Arya Dipa');
            $table->json('tags')->nullable();
            $table->integer('w')->default(1600);
            $table->integer('h')->default(1067);
            $table->decimal('price', 12, 2)->default(85000.00);
            $table->string('img', 255)->nullable();
            $table->integer('downloads')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            // Foreign key ke categories (sesuai modul BAB III)
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
