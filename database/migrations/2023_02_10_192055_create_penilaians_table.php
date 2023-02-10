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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('nis');
            $table->foreignId('kelas_id');
            $table->foreignId('user_id');
            $table->foreignId('mata_pelajaran_id');
            $table->foreignId('kategori_nilai_id');
            $table->foreignId('jenis_penilaian_id');
            $table->string('tahun', 30);
            $table->integer('semester');
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
        Schema::dropIfExists('penilaians');
    }
};
