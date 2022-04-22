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
        Schema::create('voisin_keywords', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('voisin_id')->unsigned()->nullable();
            $table->foreign('voisin_id')->references('id')->on('voisins');
            $table->bigInteger('keyword_id')->unsigned()->nullable();
            $table->foreign('keyword_id')->references('id')->on('keywords');
            $table->boolean('is_keyword')->default(0);
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
        Schema::dropIfExists('voisin_keywords');
    }
};
