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
        Schema::table('hubungan_keluargas', function (Blueprint $table) {
            // Change enum to string (varchar) to support all relationship types
            $table->string('hubungan', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hubungan_keluargas', function (Blueprint $table) {
            $table->enum('hubungan', [
                'Kepala Keluarga',
                'Istri',
                'Anak',
                'Menantu',
                'Cucu',
                'Orang Tua',
                'Mertua',
                'Saudara',
                'Lainnya'
            ])->change();
        });
    }
};
