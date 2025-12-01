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
            $table->string('brand', 100)->nullable()->after('description');
            $table->string('warranty', 200)->nullable()->after('brand');
            $table->string('dimensions', 100)->nullable()->after('warranty');
            $table->string('material', 100)->nullable()->after('dimensions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['brand', 'warranty', 'dimensions', 'material']);
        });
    }
};
