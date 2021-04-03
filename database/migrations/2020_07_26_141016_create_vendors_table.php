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
            $table->string('phone_number')->unique();
            $table->text('address')->nullable();
            $table->json('social_handles')->nullable();
            $table->text('about_business')->nullable();
            $table->foreignId('area_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('no action');
            $table->string('profile_image')->default('placeholder.png');
            $table->string('cover_image')->default('cover_placeholder.jpg');
            $table->string('password');
            $table->json('other_details')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('email_verified')->default(0);
            $table->string('email_verification_token');
            $table->timestamp('password_token_time')->nullable();
            $table->string('password_reset_token')->nullable();
            $table->string('google_id')->nullable();
            $table->rememberToken();

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
