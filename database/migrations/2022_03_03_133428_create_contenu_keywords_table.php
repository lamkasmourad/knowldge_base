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
        Schema::create('contenu_keywords', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contenu_id')->unsigned()->nullable();
            $table->foreign('contenu_id')->references('id')->on('contenus');
            $table->bigInteger('keyword_id')->unsigned()->nullable();
            $table->foreign('keyword_id')->references('id')->on('keywords');
            $table->integer('weight')->default(0);
            $table->boolean('is_synonym')->default(0);
            $table->boolean('is_synonym_global')->default(0);
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
        Schema::dropIfExists('contenu_keywords');
    }
};
