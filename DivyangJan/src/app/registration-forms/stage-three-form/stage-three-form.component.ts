import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { RegistrationService } from 'src/app/Service/registration.service';
import { AuthService } from 'src/app/Service/auth.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';
declare var $: any

@Component({
  selector: 'app-stage-three-form',
  templateUrl: './stage-three-form.component.html',
  styleUrls: ['./stage-three-form.component.sass']
})
export class StageThreeFormComponent implements OnInit {

  registration_third_part = new FormGroup({
    railway_concession_certificate: new FormControl('', Validators.required), 
    handicapped_certificate: new FormControl('', Validators.required),
    age_certificate: new FormControl('', Validators.required),
    aadhaar_card: new FormControl('', Validators.required),
    address_proof: new FormControl('', Validators.required),
    passport_size_photo: new FormControl('', Validators.required),
  });

  db_user_identifier: string = "";
  files_id_of_user: any;
  fileToUpload : any = []

  
  railwayConcessionCertificate: any;
  handicappedCertificate: any;
  ageCertificate: any;
  aadhaarCard: any;
  addressProof: any;
  passportSizePhoto: any;

  //validation
  is_submitted: boolean = false
  uploaded_railway_concession_certificate: any
  is_update_valid: number = 0
  is_RailwayConcessionCertificate_deleted: boolean = false
  is_HandicappedCertificate_deleted: boolean = false
  is_AgeCertificate_deleted: boolean = false
  is_AadhaarCard_deleted: boolean = false
  is_AddressProof_deleted: boolean = false
  is_PassportSizePhoto_deleted: boolean = false
  verifyRegistartion: any

  constructor(private client: RegistrationService, private auth: AuthService, private route: Router, private spinner: NgxSpinnerService) { }

  ngOnInit(): void {
    this.getUserDetails();
  }

  previous(){
    this.route.navigateByUrl('registration-step-2');
  }

  async getUserDetails(){
    this.spinner.show();
    await this.auth.getUser()
                .toPromise()
                .then((response) => {
                  const data: any = response;
                  console.log(data.id);
                    this.db_user_identifier = data.id;
                    this.verifyRegistartion = data.is_submitted
                    console.log(this.db_user_identifier)
                    this.ReadThirdForm(this.db_user_identifier)
                  this.spinner.hide();
                })
                .catch((error) => {

                  console.log(error);
                  // if (localStorage.getItem('ACCESS_TOKEN') != null) {
                  //   console.log(localStorage.getItem('ACCESS_TOKEN'))
                  //   Swal.fire({
                  //     icon: 'error',
                  //     title: 'Session Expired',
                  //     text: 'LoginIn Time Out',
                  //   });
                  // }
                });
                this.spinner.hide();
                this.fileToUpload = []
  }

  async ReadThirdForm(id: any){
    this.spinner.show();
    console.log(id)
    
    await this.client.registrationPartThreeRead(id)
                .toPromise()
                .then((response) => {
                  console.log(response)
                  const data: any = response;
                  // validation variables
                    this.is_update_valid = 0
                    this.is_RailwayConcessionCertificate_deleted = false;
                    this.is_HandicappedCertificate_deleted = false;
                    this.is_AgeCertificate_deleted = false;
                    this.is_AadhaarCard_deleted = false;
                    this.is_AddressProof_deleted = false;
                    this.is_PassportSizePhoto_deleted = false;
                  //validation variables END
                  this.uploaded_railway_concession_certificate = data['railway_concession_certificate'];
                  this.files_id_of_user = data[0].id
                  var is_user_known = new String(this.files_id_of_user)
                  console.log(is_user_known)
                  this.is_update_valid = is_user_known.length
                  console.log(this.is_update_valid)
                  console.log(data[0].railway_concession_certificate)
                  if (this.verifyRegistartion == 1) {
                    this.is_submitted = true;
                  }
                  this.spinner.hide();
                })
                .catch((error) => {

                  console.log(error);
                    // Swal.fire({
                    //   icon: 'error',
                    //   title: 'Session Expired',
                    //   text: 'LoginIn Time Out',
                    // });
                  });
                this.spinner.hide();
  }

  async railway_concession_certificate(event: any){
    this.railwayConcessionCertificate = event.target.files[0];
    if (this.is_RailwayConcessionCertificate_deleted == true) {
      const formData: FormData = new FormData();
        formData.append('railwayConcessionCertificate', this.railwayConcessionCertificate, this.railwayConcessionCertificate.name);
        await this.client.update_RailwayConcessionCertificate(formData)
        .toPromise()
        .then((response) => {
          const data: any = response
          if (data.status == 'success') {
            Swal.fire({
              title: 'RailwayConcessionCertificate',
              text: 'Updated Successfully',
              icon: 'success'
            });
            this.is_RailwayConcessionCertificate_deleted = false
          }
          this.spinner.hide();
        })
        .catch((error) => {
          Swal.fire({
            icon: 'error',
            title: 'Oops',
            text: 'Something went wrong !',
          });
          this.spinner.hide();
        });
    }
  }

  async handicapped_certificate(event: any){
    this.handicappedCertificate = event.target.files[0];
    if (this.is_HandicappedCertificate_deleted == true) {
      const formData: FormData = new FormData();
        formData.append('handicappedCertificate', this.handicappedCertificate, this.handicappedCertificate.name);
        await this.client.update_DisabilityCertificate(formData)
        .toPromise()
        .then((response) => {
          const data: any = response
          if (data.status == 'success') {
            Swal.fire({
              title: 'DisabilityCertificate',
              text: 'Updated Successfully',
              icon: 'success'
            });
            this.is_HandicappedCertificate_deleted = false
            // this.route.navigateByUrl('');
          }
          this.spinner.hide();
        })
        .catch((error) => {
          Swal.fire({
            icon: 'error',
            title: 'Oops',
            text: 'Something went wrong !',
          });
          this.spinner.hide();
        });
    }
  }
  async age_certificate(event: any){
    this.ageCertificate = event.target.files[0];
    if(this.is_AgeCertificate_deleted == true){
        const formData: FormData = new FormData();
        formData.append('ageCertificate', this.ageCertificate, this.ageCertificate.name);
        await this.client.update_AgeCertificate(formData)
        .toPromise()
        .then((response) => {
          const data: any = response
          if (data.status == 'success') {
            Swal.fire({
              title: 'AgeCertificate',
              text: 'Updated Successfully',
              icon: 'success'
            });
            this.is_AgeCertificate_deleted = false
            // this.route.navigateByUrl('');
          }
          this.spinner.hide();
        })
        .catch((error) => {
          Swal.fire({
            icon: 'error',
            title: 'Oops',
            text: 'Something went wrong !',
          });
          this.spinner.hide();
        });
    }
  
  }
  async aadhaar_card(event: any){
    this.aadhaarCard = event.target.files[0];
    if(this.is_AadhaarCard_deleted == true){
      const formData: FormData = new FormData();
        formData.append('aadhaarCard', this.aadhaarCard, this.aadhaarCard.name);
        await this.client.update_AadhaarCard(formData)
        .toPromise()
        .then((response) => {
          const data: any = response
          if (data.status == 'success') {
            Swal.fire({
              title: 'AadhaarCard',
              text: 'Updated Successfully',
              icon: 'success'
            });
            this.is_AadhaarCard_deleted = false;
            // this.route.navigateByUrl('');
          }
          this.spinner.hide();
        })
        .catch((error) => {
          Swal.fire({
            icon: 'error',
            title: 'Oops',
            text: 'Something went wrong !',
          });
          this.spinner.hide();
        });
    }
  }
  async address_proof(event: any){
    this.addressProof = event.target.files[0];
    if(this.is_AddressProof_deleted == true){
      const formData: FormData = new FormData();
        formData.append('addressProof', this.addressProof, this.addressProof.name);
        await this.client.update_AddressProof(formData)
        .toPromise()
        .then((response) => {
          const data: any = response
          if (data.status == 'success') {
            Swal.fire({
              title: 'AddressProof',
              text: 'Updated Successfully',
              icon: 'success'
            });
            this.is_AddressProof_deleted = false
            // this.route.navigateByUrl('');
          }
          this.spinner.hide();
        })
        .catch((error) => {
          Swal.fire({
            icon: 'error',
            title: 'Oops',
            text: 'Something went wrong !',
          });
          this.spinner.hide();
        });    
    }
  }
  async passport_size_photo(event: any){
    this.passportSizePhoto = event.target.files[0];
    if(this.is_PassportSizePhoto_deleted == true){
        const formData: FormData = new FormData();
        formData.append('passportSizePhoto', this.passportSizePhoto, this.passportSizePhoto.name);
        await this.client.update_PassportsizePhoto(formData)
        .toPromise()
        .then((response) => {
          const data: any = response
          if (data.status == 'success') {
            Swal.fire({
              title: 'PassportsizePhoto',
              text: 'Updated Successfully',
              icon: 'success'
            });
            this.is_PassportSizePhoto_deleted = false
            // this.route.navigateByUrl('');
          }
          this.spinner.hide();
        })
        .catch((error) => {
          Swal.fire({
            icon: 'error',
            title: 'Oops',
            text: 'Something went wrong !',
          });
          this.spinner.hide();
        });
    }
  }

  view_concession_certificate(){
    const url = 'http://127.0.0.1:8000/api/read_RailwayConcessionCertificate/'+this.db_user_identifier;
    window.open(url);
  }

  view_disability_certificate(){
    const url = 'http://127.0.0.1:8000/api/read_DisabilityCertificate/'+this.db_user_identifier;
    window.open(url);
  }

  view_age_certificate(){
    const url = 'http://127.0.0.1:8000/api/read_AgeCertificate/'+this.db_user_identifier;
    window.open(url);
  }

  view_aadhaar_card(){
    const url = 'http://127.0.0.1:8000/api/read_AadhaarCard/'+this.db_user_identifier;
    window.open(url);
  }

  view_address_proof(){
    const url = 'http://127.0.0.1:8000/api/read_AddressProof/'+this.db_user_identifier;
    window.open(url);
  }

  view_passportsize_photo(){
    const url = 'http://127.0.0.1:8000/api/read_PassportsizePhoto/'+this.db_user_identifier;
    window.open(url);
  }

  delete_concession_certificate(){
    this.is_RailwayConcessionCertificate_deleted = true;
  }
  delete_disability_certificate(){
    this.is_HandicappedCertificate_deleted = true;
  }
  delete_age_certificate(){
    this.is_AgeCertificate_deleted = true;
  }
  delete_aadhaar_card(){
    this.is_AadhaarCard_deleted = true;
  }
  delete_address_proof(){
    this.is_AddressProof_deleted = true;
  }
  delete_passportsize_photo(){
    this.is_PassportSizePhoto_deleted = true;
  }

  async submit() {
    // this.spinner.show();
    if (this.registration_third_part.valid) {
      const formData: FormData = new FormData();
      formData.append('railwayConcessionCertificate', this.railwayConcessionCertificate, this.railwayConcessionCertificate.name)
      formData.append('handicappedCertificate', this.handicappedCertificate, this.handicappedCertificate.name)
      formData.append('ageCertificate', this.ageCertificate, this.ageCertificate.name)
      formData.append('aadhaarCard', this.aadhaarCard, this.aadhaarCard.name)
      formData.append('addressProof', this.addressProof, this.addressProof.name)
      formData.append('passportSizePhoto', this.passportSizePhoto, this.passportSizePhoto.name)
      await this.client.registrationPartThree(formData)
      .toPromise()
      .then((response) => {
        const data: any = response
        console.log(data)
        if (data.status == 'success') {
          Swal.fire({
            title: 'Registration of Stage 3',
            text: 'Completed Successfully',
            icon: 'success',
            showConfirmButton: true,
            confirmButtonColor: '#2196f3',
            confirmButtonText: 'Ok',
          });
          this.ReadThirdForm(this.db_user_identifier)
          // this.route.navigateByUrl('');
        }
        this.spinner.hide();
      })
      .catch((error) => {
        Swal.fire({
          icon: 'error',
          title: 'Oops',
          text: 'Something went wrong !',
        });
        this.spinner.hide();
      });
    }
  }

  submitForRailways(){
    Swal.fire({
      title: 'Are You Sure To Submit ?',
      html: 'Once Submitted Data Cannot Be Changed. <br>एक बार सबमिट किए गए डेटा को बदला नहीं जा सकता है।',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#d33',
      showConfirmButton: true,
      confirmButtonColor: '#2196f3',
      confirmButtonText: 'Yes Submit',
    }).then(async (resp) => {
      if (resp.isConfirmed) {
        await this.client.registartion_Submission()
        .toPromise()
        .then((response) => {
          const data: any = response
          console.log(data)
          if (data.status == 'success') {
            Swal.fire({
              title: 'Registration Completed',
              html: 'All The Data is Submitted To Railways.<br> You Will Be Verified WithIn 7-days.',
              icon: 'success'
            });
            this.route.navigateByUrl('');
          }
          this.spinner.hide();
        })
        .catch((error) => {
          Swal.fire({
            icon: 'error',
            title: 'Oops',
            text: 'Something went wrong !',
          });
          this.spinner.hide();
        });
      }
    })
  }

  async logout(){
    await this.auth.logout();
  }

}
