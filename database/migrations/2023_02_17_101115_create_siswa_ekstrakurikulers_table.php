<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa_ekstrakurikulers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nis');
            $table->foreignId('kelas_id');
            $table->foreignId('ekstrakurikuler_id');
            $table->string('tingkat',3)->nullable();
            $table->string('tahun', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa_ekstrakurikulers');
    }
};
