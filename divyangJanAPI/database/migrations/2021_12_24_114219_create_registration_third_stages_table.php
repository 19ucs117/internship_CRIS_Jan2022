<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationThirdStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_third_stages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('handicapped_person_id');
            $table->text('railway_concession_certificate');
            $table->text('disability_or_handicapped_certificate');
            $table->text('age_certificate');
            $table->text('aadhaar_card');
            $table->text('address_proof');
            $table->text('passportsize_photo');
            $table->timestamps();
            $table->foreign('handicapped_person_id')->references('id')->on('users')
                                                                        ->onUpdate('cascade')
                                                                        ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration_third_stages');
    }
}
