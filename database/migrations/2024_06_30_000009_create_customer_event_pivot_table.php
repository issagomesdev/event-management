<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerEventPivotTable extends Migration
{
    public function up()
    {
        Schema::create('customer_event', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id', 'event_id_fk_9913044')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_id_fk_9913044')->references('id')->on('customers')->onDelete('cascade');
        });
    }
}
