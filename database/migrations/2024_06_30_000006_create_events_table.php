<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->longText('description')->nullable();
            $table->longText('rules')->nullable();
            $table->string('link')->nullable();
            $table->string('pixel')->nullable();
            $table->string('visualization')->nullable();
            $table->string('type')->nullable();
            $table->string('allow_guests')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
