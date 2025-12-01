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
        Schema::create('indonesia_regions', function (Blueprint $table) {
            $table->string('code', 13)->primary();
            $table->string('name', 100)->nullable();
            $table->string('capital', 100)->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->float('elv')->default(0);
            $table->tinyInteger('tz')->nullable();
            $table->double('luas')->nullable();
            $table->double('penduduk')->nullable();
            $table->longText('path')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indonesia_regions');
    }
};
