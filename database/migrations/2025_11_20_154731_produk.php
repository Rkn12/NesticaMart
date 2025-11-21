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
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->nullOnDelete();

            $table->string('name', 200);
            $table->text('description');
            $table->bigInteger('price');
            $table->integer('stock');
            $table->integer('weight')->nullable();
            $table->enum('condition', ['new','used'])->default('new');

            // lokasi berdasarkan PDF
            $table->string('location_province', 100);
            $table->string('location_city', 100);

            // rating dari review
            $table->decimal('average_rating', 3, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
