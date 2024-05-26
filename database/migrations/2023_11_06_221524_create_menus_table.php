<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('url')->nullable();
            $table->integer('order')->unsigned()->default(0);
            $table->string('custom_class')->nullable();
            $table->timestamps();
        });
    }
};
