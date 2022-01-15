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
              $table->uuid('id')->primary();
              $table->bigInteger('aadhaarNo');
              $table->string('candidate_first_name');
              $table->string('candidate_middle_name');
              $table->string('candidate_last_name');
              $table->enum('relation', ['Husband', 'Father']);
              $table->string('relations_first_name');
              $table->string('relations_middle_name');
              $table->string('relations_last_name');
              $table->date('dateofbirth');
              $table->enum('gender', ['male', 'female', 'other']);
              $table->string('email')->nullable();
              $table->timestamp('email_verified_at')->nullable();
              $table->bigInteger('phone_number');
              $table->bigInteger('alternate_phone_number')->nullable();
              $table->text('address');
              $table->integer('pincode');
              $table->string('password');
              $table->boolean('is_submitted')->default(0);
              $table->rememberToken();
              $table->timestamps();
              $table->unique(['aadhaarNo', 'phone_number']);
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
