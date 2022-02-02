<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number', 20)->unique()->nullable();
            $table->timestamp('phone_number_verified_at')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_created_at')->nullable();
            $table->string('website')->nullable();
            $table->string('bio', 150)->nullable();
            $table->enum('gender', ['male', 'female', 'others'])->nullable();
            $table->boolean('is_admin')->default(false);
            $table->timestamp('username_last_updated_at')->useCurrent();
            $table->tinyInteger('username_update_attempts')->default(0);
            $table->rememberToken();
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
