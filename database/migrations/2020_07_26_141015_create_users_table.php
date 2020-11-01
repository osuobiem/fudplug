<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number')->unique();
            // Please Comment This Before Rolling Back Migration
            $table->string('address')->nullable();
            // Please Comment This Before Rolling Back Migration
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('profile_image')->default('placeholder.png');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->foreignId('area_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('no action');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
