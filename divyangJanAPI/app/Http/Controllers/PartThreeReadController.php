<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Registration_third_stage;

class PartThreeReadController extends Controller
{
    public function readRailway_concession_certificate($hadicappedID)
     {
      $registration_partThree_data = Registration_third_stage::where('handicapped_person_id', $hadicappedID)->get();
      if ($registration_partThree_data) {
        $path = storage_path('app/public/railway_concession_certificate/' . $registration_partThree_data[0]->railway_concession_certificate);
         return response()->file($path);
      }
      return response()->json("No File Found", 404);
     }

     public function readDisability_or_handicapped_certificate($hadicappedID)
     {
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id', $hadicappedID)->get();
       if ($registration_partThree_data) {
        $path = storage_path('app/public/handicapped_certificate/' . $registration_partThree_data[0]->disability_or_handicapped_certificate);
        return response()->file($path);
       }
       return response()->json("No File Found", 404);
     }

     public function readAge_certificate($hadicappedID)
     {
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id', $hadicappedID)->get();
       if ($registration_partThree_data) {
        $path = storage_path('app/public/age_certificate/' . $registration_partThree_data[0]->age_certificate);
        return response()->file($path);
       }
       return response()->json("No File Found", 404);
     }

     public function readAadhaar_card($hadicappedID)
     {
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id', $hadicappedID)->get();
       if ($registration_partThree_data) {
        $path = storage_path('app/public/aadhaar_card/' . $registration_partThree_data[0]->aadhaar_card);
        return response()->file($path);
       }
       return response()->json("No File Found", 404);
     }

     public function readAddress_proof($hadicappedID)
     {
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id', $hadicappedID)->get();
       if ($registration_partThree_data) {
        $path = storage_path('app/public/address_proof/' . $registration_partThree_data[0]->address_proof);
        return response()->file($path);
       }
       return response()->json("No File Found", 404);
     }

     public function readPassportsize_photo($hadicappedID)
     {
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id', $hadicappedID)->get();
       if ($registration_partThree_data) {
        $path = storage_path('app/public/passport_size_photo/' . $registration_partThree_data[0]->passportsize_photo);
        return response()->file($path);
       }
       return response()->json("No File Found", 404);
     }
}
