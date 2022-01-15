<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration_third_stage extends Model
{
  use HasFactory;
  protected $primaryKey = 'id';
  public $incrementing = false;
  protected $keyType = 'string';
  protected $table = 'registration_third_stages';


  protected $fillable = [
      'id',
      'handicapped_person_id',
      'railway_concession_certificate',
      'disability_or_handicapped_certificate',
      'age_certificate',
      'aadhaar_card',
      'address_proof',
      'passportsize_photo',
  ];
}
