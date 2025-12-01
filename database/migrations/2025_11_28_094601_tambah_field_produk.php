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
        Schema::table('products', function (Blueprint $table) {
            $table->string('merek')->nullable()->after('name'); // Brand/Merek
            $table->text('garansi')->nullable(); // Warranty
            $table->json('dimensi')->nullable(); // Dimensions (panjang, lebar, tinggi)
            $table->string('bahan')->nullable(); // Material
            $table->decimal('berat', 8, 2)->nullable(); // Weight in kg
            $table->string('kondisi')->default('baru'); // Condition: baru/bekas
            $table->json('spesifikasi')->nullable(); // Technical specifications
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['merek', 'garansi', 'dimensi', 'bahan', 'berat', 'kondisi', 'spesifikasi']);
        });
    }
};
