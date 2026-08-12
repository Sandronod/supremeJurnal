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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name_ka');
            $table->string('site_name_en');
            $table->string('issn')->nullable();
            $table->string('copyright_text_ka')->nullable();
            $table->string('copyright_text_en')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address_ka')->nullable();
            $table->string('address_en')->nullable();
            $table->text('map_embed_url')->nullable();
            $table->string('facebook_url')->nullable();
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
        Schema::dropIfExists('settings');
    }
};
