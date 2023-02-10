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
        Schema::create('guru_mata_pelajarans', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->foreignId('mata_pelajaran_id');
            $table->primary(['user_id','mata_pelajaran_id']);
            $table->index(['user_id', 'mata_pelajaran_id']);
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
        Schema::dropIfExists('guru_mata_pelajarans');
    }
};
