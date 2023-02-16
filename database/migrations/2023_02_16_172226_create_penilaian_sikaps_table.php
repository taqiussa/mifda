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
        Schema::create('penilaian_sikaps', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('tahun');
            $table->string('semester');
            $table->foreignId('kelas_id');
            $table->foreignId('mata_pelajaran_id');
            $table->foreignId('nis');
            $table->foreignId('kategori_sikap_id');
            $table->foreignId('jenis_sikap_id');
            $table->foreignId('user_id');
            $table->integer('nilai');
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
        Schema::dropIfExists('penilaian_sikaps');
    }
};
