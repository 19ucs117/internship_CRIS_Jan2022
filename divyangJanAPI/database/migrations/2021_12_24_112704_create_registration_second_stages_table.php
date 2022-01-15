<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationSecondStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_second_stages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('handicapped_person_id');
            $table->string('disability_certificate_number')->unique();
            $table->enum('nature_of_disability', ['Permanent', 'Temporary']);
            $table->string('type_of_category');
            $table->string('railway_concession_certificate_issuing_hospital');
            $table->string('hospital_address');
            $table->string('name_of_doctor');
            $table->string('registration_number_of_doctor');
            $table->date('date_of_issue_of_concession_certificate');
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
        Schema::dropIfExists('registration_second_stages');
    }
}
