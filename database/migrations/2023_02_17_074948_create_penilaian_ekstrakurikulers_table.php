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
        Schema::create('penilaian_ekstrakurikulers', function (Blueprint $table) {
            $table->id();
            $table->string('tahun');
            $table->string('semester');
            $table->foreignId('ekstrakurikuler_id');
            $table->foreignId('nis');
            $table->foreignId('kelas_id');
            $table->foreignId('user_id');
            $table->integer('nilai')->nullable();
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
        Schema::dropIfExists('penilaian_ekstrakurikulers');
    }
};
