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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('simpanan_pokok')->default(0);
            $table->bigInteger('simpanan_wajib')->default(0);
            $table->bigInteger('simpanan_sukarela')->default(0);
            $table->bigInteger('hutang')->default(0); // sisa pinjaman
            $table->bigInteger('pokok_pinjaman')->default(0);
            $table->bigInteger('monthly_payment')->default(0);
            $table->date('jatuh_tempo_pinjaman')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'simpanan_pokok',
                'simpanan_wajib',
                'simpanan_sukarela',
                'hutang',
                'pokok_pinjaman',
                'monthly_payment',
                'jatuh_tempo_pinjaman',
            ]);
        });
    }
};
