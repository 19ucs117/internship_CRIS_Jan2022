<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration_second_stage extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  public $incrementing = false;
  protected $keyType = 'string';
  protected $table = 'registration_second_stages';

  protected $fillable = [
      'id',
      'handicapped_person_id',
      'disability_certificate_number',
      'nature_of_disability',
      'type_of_category',
      'railway_concession_certificate_issuing_hospital',
      'hospital_address',
      'name_of_doctor',
      'registration_number_of_doctor',
      'date_of_issue_of_concession_certificate',
  ];
}
