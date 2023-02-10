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
        Schema::create('penilaian_rapors', function (Blueprint $table) {
            $table->id();
            $table->integer('tingkat');
            $table->string('tahun', 30);
            $table->integer('semester');
            $table->foreignId('kategori_nilai_id');
            $table->foreignId('jenis_penilaian_id');
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
        Schema::dropIfExists('penilaian_rapors');
    }
};
