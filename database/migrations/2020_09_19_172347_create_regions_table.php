<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->integer('region_id');
            $table->integer('country_id');
            $table->string('title_ru');
            $table->string('title_ua');
            $table->string('title_be');
            $table->string('title_en');
            $table->string('title_es');
            $table->string('title_pt');
            $table->string('title_de');
            $table->string('title_fr');
            $table->string('title_it');
            $table->string('title_pl');
            $table->string('title_ja');
            $table->string('title_lt');
            $table->string('title_lv');
            $table->string('title_cz');
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
        Schema::dropIfExists('regions');
    }
}
