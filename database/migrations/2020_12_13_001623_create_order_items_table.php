<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade')->onUpdate('no action');
            $table->integer('item_id');
            $table->enum('order_type', ['simple', 'advanced']);
            $table->json('order_detail');
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
        Schema::dropIfExists('order_items');
    }
}
