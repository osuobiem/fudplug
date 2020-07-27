<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('address');
            $table->json('social_handles');
            $table->text('about_business');
            $table->foreignId('area_id')->constrained()->onDelete('cascade')->onUpdate('no action');
            $table->string('profile_image');
            $table->string('password');

            $table->softDeletes();
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
        Schema::dropIfExists('vendors');
    }
}
