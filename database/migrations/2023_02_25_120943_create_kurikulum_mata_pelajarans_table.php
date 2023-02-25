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
        Schema::create('kurikulum_mata_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurikulum_id');
            $table->foreignId('mata_pelajaran_id');
            $table->string('tahun', 30);
            $table->string('tingkat', 3);
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
        Schema::dropIfExists('kurikulum_mata_pelajarans');
    }
};
