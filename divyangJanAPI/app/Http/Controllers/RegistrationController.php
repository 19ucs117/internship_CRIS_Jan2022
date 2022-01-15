<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


use App\Models\User;
use App\Models\Registration_second_stage;
use App\Models\Registration_third_stage;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{

     public function __construct()
     {
         $this->middleware('auth:api', ['except' => ['submitRegistrationPartOne']]);
     }

     public function submitRegistrationPartOne(Request $request)
     {
       $status="";
       $message="";

       $request->validate([
        'aadhaarNumber' => ['required', 'min:12', 'max: 12'],
        'candidate_firstName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'candidate_middleName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'candidate_lastName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'relation_name' => ['required'],
        'relations_firstName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'relations_middleName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'relations_lastName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'date_of_birth' => ['required'],
        'gender' => ['required'],
        'email' => ['required', 'email'],
        'mobileNumber' => ['required','min: 10','max: 10', 'regex:/^[0-9]{10}$/'],
        'alternateContactNumber' => ['required', 'regex:/^[0-9]{10}$/'],
        'address' => ['required'],
        'pincode' => ['required', 'max: 6', 'min: 6', 'regex:/^[0-9]{6}$/'],
        'password' => ['required', 'min: 8'],
       ]);

       try {
           User::create([
               'id' => Str::uuid(),
               'aadhaarNo' => $request->aadhaarNumber,
               'candidate_first_name' => trim(strtoupper($request->candidate_firstName)),
               'candidate_middle_name' => trim(strtoupper($request->candidate_middleName)),
               'candidate_last_name' => trim(strtoupper($request->candidate_lastName)),
               'relation' => $request->relation_name,
               'relations_first_name' => trim(strtoupper($request->relations_firstName)),
               'relations_middle_name' => trim(strtoupper($request->relations_middleName)),
               'relations_last_name' => trim(strtoupper($request->relations_lastName)),
               'dateofbirth' => $request->date_of_birth,
               'gender' => $request->gender,
               'email' => $request->email,
               'phone_number' => $request->mobileNumber,
               'alternate_phone_number' => $request->alternateContactNumber,
               'address' => trim(strtoupper($request->address)),
               'pincode' => $request->pincode,
               'password' => bcrypt($request->password),
           ]);
           $status = 'success';
           $message = "User Added Successfully";
       } catch (Exception $e) {
           Log::warning('Error Adding User',$e);
           $status = $e->info;
           $message = "Unable to Add User";
       }

       return response()->json(['status' => $status,'message'=>$message]);
     }

     public function updateRegistrationPartOne(Request $request, $handicapped_persons_id)
     {
       $status="";
       $message="";

       $request->validate([
        'aadhaarNumber' => ['required', 'min:12', 'max: 12', 'regex:/^[0-9]{12}$/'],
        'candidate_firstName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'candidate_middleName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'candidate_lastName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'relation_name' => ['required'],
        'relations_firstName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'relations_middleName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'relations_lastName' => ['required', 'regex:/^[a-zA-Z ]*$/'],
        'date_of_birth' => ['required'],
        'gender' => ['required'],
        'email' => ['required', 'email'],
        'mobileNumber' => ['required','min: 10','max: 10', 'regex:/^[0-9]{10}$/'],
        'alternateContactNumber' => ['required', 'regex:/^[0-9]{10}$/'],
        'address' => ['required'],
        'pincode' => ['required', 'max: 6', 'min: 6', 'regex:/^[0-9]{6}$/'],
        'password' => ['required', 'min: 8'],
       ]);

       try {

         if ($registartion_part_one = User::find($handicapped_persons_id)) {
           $registartion_part_one->aadhaarNo = $request->aadhaarNumber;
           $registartion_part_one->candidate_first_name = $request->candidate_firstName;
           $registartion_part_one->candidate_middle_name = $request->candidate_middleName;
           $registartion_part_one->candidate_last_name = $request->candidate_lastName;
           $registartion_part_one->relation = $request->relation_name;
           $registartion_part_one->relations_first_name = $request->relations_firstName;
           $registartion_part_one->relations_middle_name = $request->relations_middleName;
           $registartion_part_one->relations_last_name = $request->relations_lastName;
           $registartion_part_one->dateofbirth = $request->date_of_birth;
           $registartion_part_one->gender = $request->gender;
           $registartion_part_one->email = $request->email;
           $registartion_part_one->phone_number = $request->mobileNumber;
           $registartion_part_one->alternate_phone_number = $request->alternateContactNumber;
           $registartion_part_one->address = $request->address;
           $registartion_part_one->pincode = $request->pincode;
           $registartion_part_one->save();
         }

           $status = 'success';
           $message = "User Updated Successfully";
       } catch (Exception $e) {
           Log::warning('Error Adding User',$e->getMessage());
           $status = "error";
           $message = "Unable to Add User";
       }

       return response()->json(['status' => $status,'message'=>$message]);
     }


     public function submitRegistrationPartTwo(Request $request)
     {
       $status="";
       $message="";

       $request->validate([
        'handicapped_person_id' => ['required'],
        'disability_certificate_number' => ['required'],
        'nature_of_disability' => ['required'],
        'type_of_category' => ['required'],
        'railway_concession_certificate_issuing_hospital' => ['required'],
        'hospital_address' => ['required'],
        'doctor_name' => ['required'],
        'doctor_registration_no' => ['required'],
        'date_of_issue_concession_certificate' => ['required'],
       ]);

       try {
           Registration_second_stage::create([
               'id' => Str::uuid(),
               'handicapped_person_id' => $request->handicapped_person_id,
               'disability_certificate_number' => $request->disability_certificate_number,
               'nature_of_disability' => $request->nature_of_disability,
               'type_of_category' => $request->type_of_category,
               'railway_concession_certificate_issuing_hospital' => $request->railway_concession_certificate_issuing_hospital,
               'hospital_address' => $request->hospital_address,
               'name_of_doctor' => trim(strtoupper($request->doctor_name)),
               'registration_number_of_doctor' => $request->doctor_registration_no,
               'date_of_issue_of_concession_certificate' => $request->date_of_issue_concession_certificate,
           ]);
           $status = 'success';
           $message = "STAGE-|| Added Successfully";
       } catch (Exception $e) {
           Log::warning('Error Adding User',$e);
           $status = $e->info;
           $message = "Unable to Add User";
       }

       return response()->json(['status' => $status,'message'=>$message]);
     }

     public function readRegistrationFormPartTwo(Request $request, $handicapped_persons_id)
     {
       $registration_partTwo_data = Registration_second_stage::where('handicapped_person_id', $handicapped_persons_id)->get();
       return response()->json($registration_partTwo_data);
     }

     public function updateRegistrationPartTwo(Request $request, $handicapped_persons_id)
     {
       $status="";
       $message="";

       $request->validate([
        'disability_certificate_number' => ['required'],
        'nature_of_disability' => ['required'],
        'type_of_category' => ['required'],
        'railway_concession_certificate_issuing_hospital' => ['required'],
        'hospital_address' => ['required'],
        'doctor_name' => ['required'],
        'doctor_registration_no' => ['required'],
        'date_of_issue_concession_certificate' => ['required'],
       ]);

       try {
         if ($registartion_part_two = Registration_second_stage::find($handicapped_persons_id)) {
           $registartion_part_two->disability_certificate_number = $request->disability_certificate_number;
           $registartion_part_two->nature_of_disability = $request->nature_of_disability;
           $registartion_part_two->type_of_category = $request->type_of_category;
           $registartion_part_two->railway_concession_certificate_issuing_hospital = $request->railway_concession_certificate_issuing_hospital;
           $registartion_part_two->hospital_address = $request->hospital_address;
           $registartion_part_two->name_of_doctor = $request->doctor_name;
           $registartion_part_two->registration_number_of_doctor = $request->doctor_registration_no;
           $registartion_part_two->date_of_issue_of_concession_certificate = $request->date_of_issue_concession_certificate;
           $registartion_part_two->save();
         }
           $status = 'success';
           $message = "STAGE-|| Updated Successfully";
       } catch (Exception $e) {
           Log::warning('Error Adding User',$e);
           $status = $e->info;
           $message = "Unable to Add User";
       }

       return response()->json(['status' => $status,'message'=>$message]);
     }

     public function submitRegistrationPartThree(Request $request)
     {
       $status="";
       $message="";
       try{
        if ($request->hasFile('railwayConcessionCertificate')) {
          $completeRCCFileName = $request->file('railwayConcessionCertificate')->getClientOriginalName();
          $RCCfileNameOnly = pathinfo($completeRCCFileName, PATHINFO_FILENAME);
          $RCCfileExtension = $request->file('railwayConcessionCertificate')->getClientOriginalExtension();
          $RCCfile = str_replace(' ', '_', $RCCfileNameOnly) . '-' . rand() . '_' . time() . '.' . $RCCfileExtension;
          $RCCfilePath = $request->file('railwayConcessionCertificate')->storeAs('public/railway_concession_certificate', $RCCfile);       
        }
        if ($request->hasFile('handicappedCertificate')) {
          $completeHCFileName = $request->file('handicappedCertificate')->getClientOriginalName();
          $HCfileNameOnly = pathinfo($completeHCFileName, PATHINFO_FILENAME);
          $HCfileExtension = $request->file('handicappedCertificate')->getClientOriginalExtension();
          $HCfile = str_replace(' ', '_', $HCfileNameOnly) . '-' . rand() . '_' . time() . '.' . $HCfileExtension;
          $HCfilePath = $request->file('handicappedCertificate')->storeAs('public/handicapped_certificate', $HCfile);       
        }
        
        if ($request->hasFile('ageCertificate')) {
          $completeAGCFileName = $request->file('ageCertificate')->getClientOriginalName();
          $AGCfileNameOnly = pathinfo($completeAGCFileName, PATHINFO_FILENAME);
          $AGCfileExtension = $request->file('ageCertificate')->getClientOriginalExtension();
          $AGCfile = str_replace(' ', '_', $AGCfileNameOnly) . '-' . rand() . '_' . time() . '.' . $AGCfileExtension;
          $AGCfilePath = $request->file('ageCertificate')->storeAs('public/age_certificate', $AGCfile);       
        }
        if ($request->hasFile('aadhaarCard')) {
          $completeACFileName = $request->file('aadhaarCard')->getClientOriginalName();
          $ACfileNameOnly = pathinfo($completeACFileName, PATHINFO_FILENAME);
          $ACfileExtension = $request->file('aadhaarCard')->getClientOriginalExtension();
          $ACfile = str_replace(' ', '_', $ACfileNameOnly) . '-' . rand() . '_' . time() . '.' . $ACfileExtension;
          $ACfilePath = $request->file('aadhaarCard')->storeAs('public/aadhaar_card', $ACfile);       
        }
        if ($request->hasFile('addressProof')) {
          $completeAPFileName = $request->file('addressProof')->getClientOriginalName();
          $APfileNameOnly = pathinfo($completeAPFileName, PATHINFO_FILENAME);
          $APfileExtension = $request->file('addressProof')->getClientOriginalExtension();
          $APfile = str_replace(' ', '_', $APfileNameOnly) . '-' . rand() . '_' . time() . '.' . $APfileExtension;
          $APfilePath = $request->file('addressProof')->storeAs('public/address_proof', $APfile);       
        } 
        if ($request->hasFile('passportSizePhoto')) {
          $completePSPFileName = $request->file('passportSizePhoto')->getClientOriginalName();
          $PSPfileNameOnly = pathinfo($completePSPFileName, PATHINFO_FILENAME);
          $PSPfileExtension = $request->file('passportSizePhoto')->getClientOriginalExtension();
          $PSPfile = str_replace(' ', '_', $PSPfileNameOnly) . '-' . rand() . '_' . time() . '.' . $PSPfileExtension;
          $PSPfilePath = $request->file('passportSizePhoto')->storeAs('public/passport_size_photo', $PSPfile);                 
        }

        Registration_third_stage::create([
          'id' => Str::uuid(),
          'handicapped_person_id' => auth()->user()->id,
          'railway_concession_certificate' => $RCCfile,
          'disability_or_handicapped_certificate' => $HCfile,
          'age_certificate' => $AGCfile,
          'aadhaar_card' => $ACfile,
          'address_proof' => $APfile,
          'passportsize_photo' => $PSPfile
        ]);

        $status = 'success';
        $message = 'Files Stored In Database Successfully';

       }catch(Exception $e){
        Log::warning('Error Storing File',$e->getMessage());
        $status = 'error';
        $message = 'Unable to Store In Database';
       }
       
       
       return response()->json(['status' => $status,'message'=> $message]);
     }
     
     public function readRegistrationFormPartThree($handicapped_persons_id)
     {
      $registration_partThree_data = Registration_third_stage::where('handicapped_person_id',$handicapped_persons_id)->get();
      return response()->json($registration_partThree_data);
     }

     public function updateRailway_concession_certificate(Request $request)
     {
       $status = "";
       $message = "";
       try{
        $registration_partThree_data = Registration_third_stage::where('handicapped_person_id',auth()->user()->id)->get();
        if($registration_partThree_data != null){
          $completeRCCFileName = $request->file('railwayConcessionCertificate')->getClientOriginalName();
          $RCCfileNameOnly = pathinfo($completeRCCFileName, PATHINFO_FILENAME);
          $RCCfileExtension = $request->file('railwayConcessionCertificate')->getClientOriginalExtension();
          $RCCfile = str_replace(' ', '_', $RCCfileNameOnly) . '-' . rand() . '_' . time() . '.' . $RCCfileExtension;
          $RCCfilePath = $request->file('railwayConcessionCertificate')->storeAs('public/railway_concession_certificate', $RCCfile);
          unlink(storage_path('app/public/railway_concession_certificate/' . $registration_partThree_data[0]->railway_concession_certificate));
          $registration_partThree_data[0]->railway_concession_certificate = $RCCfile;
          $registration_partThree_data[0]->save();
        }else{
          $status = "error";
          $message = "ID Not Found";
         }
        $status = "success";
        $message = "Updated RailwayConcessionCertificate Successfully";
       }catch(Exception $e){
          Log::warning('Error Updating RailwayConcessionCertificate',$e->getMessage());
          $status = "error";
          $message = "Unable to Update RailwayConcessionCertificate";
       }
       return response()->json(['status' => $status,'message'=>$message]);
     }

     public function updateDisability_or_handicapped_certificate(Request $request)
     {
      $status = "";
      $message = "";
      try{
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id',auth()->user()->id)->get();
       if($registration_partThree_data != null){
         $completeHCFileName = $request->file('handicappedCertificate')->getClientOriginalName();
         $HCfileNameOnly = pathinfo($completeHCFileName, PATHINFO_FILENAME);
         $HCfileExtension = $request->file('handicappedCertificate')->getClientOriginalExtension();
         $HCfile = str_replace(' ', '_', $HCfileNameOnly) . '-' . rand() . '_' . time() . '.' . $HCfileExtension;
         $HCfilePath = $request->file('handicappedCertificate')->storeAs('public/handicapped_certificate', $HCfile);
         unlink(storage_path('app/public/handicapped_certificate/' . $registration_partThree_data[0]->disability_or_handicapped_certificate));
         $registration_partThree_data[0]->disability_or_handicapped_certificate = $HCfile;
         $registration_partThree_data[0]->save();
       }else{
        $status = "error";
        $message = "ID Not Found";
       }
       $status = "success";
       $message = "Updated HandicappedCertificate Successfully";
      }catch(Exception $e){
         Log::warning('Error Updating HandicappedCertificate',$e->getMessage());
         $status = "error";
         $message = "Unable to Update HandicappedCertificate";
      }
      return response()->json(['status' => $status,'message'=>$message]);
     }

     public function updateAge_certificate(Request $request)
     {
      $status = "";
      $message = "";
      try{
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id',auth()->user()->id)->get();
       if($registration_partThree_data != null){
         $completeAGCFileName = $request->file('ageCertificate')->getClientOriginalName();
         $AGCfileNameOnly = pathinfo($completeAGCFileName, PATHINFO_FILENAME);
         $AGCfileExtension = $request->file('ageCertificate')->getClientOriginalExtension();
         $AGCfile = str_replace(' ', '_', $AGCfileNameOnly) . '-' . rand() . '_' . time() . '.' . $AGCfileExtension;
         $AGCfilePath = $request->file('ageCertificate')->storeAs('public/age_certificate', $AGCfile);
         unlink(storage_path('app/public/age_certificate/' . $registration_partThree_data[0]->age_certificate));
         $registration_partThree_data[0]->age_certificate = $AGCfile;
         $registration_partThree_data[0]->save();
       }else{
        $status = "error";
        $message = "ID Not Founf";
       }
       $status = "success";
       $message = "Updated AgeCertificate Successfully";
      }catch(Exception $e){
         Log::warning('Error Updating AgeCertificate',$e->getMessage());
         $status = "error";
         $message = "Unable to Update AgeCertificate";
      }
      return response()->json(['status' => $status,'message'=>$message]);
     }

     public function updateAadhaar_card(Request $request)
     {
      $status = "";
      $message = "";
      try{
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id',auth()->user()->id)->get();
       if($registration_partThree_data != null){
         $completeACFileName = $request->file('aadhaarCard')->getClientOriginalName();
         $ACfileNameOnly = pathinfo($completeACFileName, PATHINFO_FILENAME);
         $ACfileExtension = $request->file('aadhaarCard')->getClientOriginalExtension();
         $ACfile = str_replace(' ', '_', $ACfileNameOnly) . '-' . rand() . '_' . time() . '.' . $ACfileExtension;
         $ACfilePath = $request->file('aadhaarCard')->storeAs('public/aadhaar_card', $ACfile); 
         unlink(storage_path('app/public/aadhaar_card/' . $registration_partThree_data[0]->aadhaar_card));
         $registration_partThree_data[0]->aadhaar_card = $ACfile;
         $registration_partThree_data[0]->save();
       }else{
        $status = "error";
        $message = "ID Not Found";
       }
       
       $status = "success";
       $message = "Updated AadhaarCard Successfully";
      }catch(Exception $e){
         Log::warning('Error Updating AadhaarCard',$e->getMessage());
         $status = "error";
         $message = "Unable to Update AadhaarCard";
      }
      return response()->json(['status' => $status,'message'=>$message]);
     }

     public function updateAddress_proof(Request $request)
     {
      $status = "";
      $message = "";
      try{
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id',auth()->user()->id)->get();
       if($registration_partThree_data != null){
         $completeAPFileName = $request->file('addressProof')->getClientOriginalName();
         $APfileNameOnly = pathinfo($completeAPFileName, PATHINFO_FILENAME);
         $APfileExtension = $request->file('addressProof')->getClientOriginalExtension();
         $APfile = str_replace(' ', '_', $APfileNameOnly) . '-' . rand() . '_' . time() . '.' . $APfileExtension;
         $APfilePath = $request->file('addressProof')->storeAs('public/address_proof', $APfile); 
         unlink(storage_path('app/public/address_proof/' . $registration_partThree_data[0]->address_proof));
         $registration_partThree_data[0]->address_proof = $APfile;
         $registration_partThree_data[0]->save();
       }else{
        $status = "error";
        $message = "ID Not Found";
       }
       
       $status = "success";
       $message = "Updated AddressProof Successfully";
      }catch(Exception $e){
         Log::warning('Error Updating AddressProof',$e->getMessage());
         $status = "error";
         $message = "Unable to Update AddressProof";
      }
      return response()->json(['status' => $status,'message'=>$message]);
     }

     public function updatePassportsize_photo(Request $request)
     {
      $status = "";
      $message = "";
      try{
       $registration_partThree_data = Registration_third_stage::where('handicapped_person_id',auth()->user()->id)->get();
       if($registration_partThree_data != null){
         $completePSPFileName = $request->file('passportSizePhoto')->getClientOriginalName();
         $PSPfileNameOnly = pathinfo($completePSPFileName, PATHINFO_FILENAME);
         $PSPfileExtension = $request->file('passportSizePhoto')->getClientOriginalExtension();
         $PSPfile = str_replace(' ', '_', $PSPfileNameOnly) . '-' . rand() . '_' . time() . '.' . $PSPfileExtension;
         $PSPfilePath = $request->file('passportSizePhoto')->storeAs('public/passport_size_photo', $PSPfile);
         unlink(storage_path('app/public/passport_size_photo/' . $registration_partThree_data[0]->passportsize_photo));
         $registration_partThree_data[0]->passportsize_photo = $PSPfile;
         $registration_partThree_data[0]->save();
       }
       else{
        $status = "error";
        $message = "ID Not Found";
       }
       $status = "success";
       $message = "Updated PassportSizePhoto Successfully";
      }catch(Exception $e){
         Log::warning('Error Updating PassportSizePhoto',$e->getMessage());
         $status = "error";
         $message = "Unable to Update PassportSizePhoto";
      }
      return response()->json(['status' => $status,'message'=>$message]);
     }

     public function CompletionOfRegistration()
     {
      $status = "";
      $message = "";
       try{
        $can_submit_ToRailways = User::find(auth()->user()->id);
        if ($can_submit_ToRailways != null) {
          $can_submit_ToRailways->is_submitted = 1;
          $can_submit_ToRailways->save();
        }
        $status = "success";
        $message = "Completed Registration Successfully";
       }catch(Exception $e){
         Log::warning('Error Submitting Registreation',$e->getMessage());
         $status = "error";
         $message = "Unable to Submit Registration";
       }
       return response()->json(['status' => $status,'message'=>$message]);
     }
     
}
