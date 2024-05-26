<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->nullable();
            $table->string('depth')->default(5);
            $table->boolean('apply_child_as_parent')->default(0);
            $table->text('levels')->nullable();
            $table->timestamps();
        });
    }
};
