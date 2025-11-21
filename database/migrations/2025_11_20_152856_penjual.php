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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();

            $table->string('store_name', 150);
            $table->text('store_description')->nullable();
            $table->string('owner_name', 150);
            $table->string('nik', 20);
            $table->string('phone', 20);
            $table->string('email', 150)->unique();

            // Lokasi
            $table->string('province', 100);
            $table->string('city', 100);
            $table->string('subdistrict', 100);
            $table->string('kelurahan', 100);
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->text('address');

            // PIC (Person In Charge)
            $table->string('pic_name', 150);
            $table->string('pic_phone', 20);
            $table->string('pic_email', 150);
            $table->string('foto_ktp_pic', 255)->nullable();
            $table->string('file_ktp_pic', 255)->nullable();

            // Verifikasi
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->text('verification_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
