<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('vendor_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('no action');
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
        Schema::dropIfExists('vendors_areas');
    }
}
