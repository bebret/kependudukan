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
        Schema::create('hubungan_keluargas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id');
            $table->unsignedBigInteger('keluarga_id');
            // Changed from enum to string to support all relationship types
            $table->string('hubungan', 50);
            $table->boolean('masih_tinggal_bersama')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('penduduk_id')
                  ->references('id')
                  ->on('penduduks')
                  ->onDelete('cascade');

            $table->foreign('keluarga_id')
                  ->references('id')
                  ->on('keluargas')
                  ->onDelete('cascade');

            $table->unique(['penduduk_id', 'keluarga_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hubungan_keluargas');
    }
};
