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
        Schema::table('data_obat', function (Blueprint $table) {
            $table->date('tanggal_kadaluarsa')->nullable()->after('periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_obat', function (Blueprint $table) {
            $table->dropColumn('tanggal_kadaluarsa');
        });
    }
};
