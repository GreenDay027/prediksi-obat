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
        Schema::create('prediksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_obat_id')->constrained('data_obat');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->double('s1');
            $table->double('s2');
            $table->double('s3');
            $table->double('at');
            $table->double('bt');
            $table->double('ct');
            $table->double('prediksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksi');
    }
};
