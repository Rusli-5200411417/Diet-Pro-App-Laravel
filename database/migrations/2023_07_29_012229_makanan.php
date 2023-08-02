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
        Schema::create('makanan', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_Bahan')->nullable();
            $table->string('Ukuran_Porsi')->nullable(); 
            $table->string('Takaran')->nullable();
            $table->string('Energi_kkal')->nullable();
            $table->string('Protein_g')->nullable();
            $table->string('Lemak_g')->nullable();
            $table->string('KH_g')->nullable();
            $table->string('Serat_Total_g')->nullable();
            $table->string('Natrium_mg')->nullable();
            $table->string('Kalium_mg')->nullable();
            $table->string('Gula_Total_g')->nullable();
            $table->string('Jenis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makanan');
    }
};
