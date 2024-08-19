<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_event_guests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id', 'event_id_fk_9913045')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_id_fk_9913045')->references('id')->on('customers')->onDelete('cascade');
            $table->string('guest');
        });
    }
};
