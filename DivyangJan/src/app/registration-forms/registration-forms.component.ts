import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { RegistrationService } from '../Service/registration.service';
import { AuthService } from '../Service/auth.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';
declare var $: any

@Component({
  selector: 'app-registration-forms',
  templateUrl: './registration-forms.component.html',
  styleUrls: ['./registration-forms.component.sass']
})
export class RegistrationFormsComponent implements OnInit {

  constructor(
    private client: RegistrationService, 
    private auth: AuthService, 
    private route: Router, 
    private spinner: NgxSpinnerService) { }

  is_submitted: boolean = false;
  db_user_identifier: any;
  is_update_valid: number  = 0
  verifyRegistartion: any

  registration_first_part = new FormGroup({
    aadhaarNumber: new FormControl('', [
      Validators.required,
      Validators.minLength(12),
      Validators.maxLength(12),
      Validators.pattern("^[0-9]*$"),
    ]),
    candidate_firstName: new FormControl('', [
      Validators.required,
      Validators.pattern("[a-zA-Z]*$"),
    ]),
    candidate_middleName: new FormControl('', [
      Validators.required,
      Validators.pattern("[a-zA-Z]*$"),
    ]),
    candidate_lastName: new FormControl('', [
      Validators.required,
      Validators.pattern("[a-zA-Z]*$"),
    ]),
    relation_name: new FormControl('', [Validators.required]),
    relations_firstName: new FormControl('', [
      Validators.required,
      Validators.pattern("[a-zA-Z]*$"),
    ]),
    relations_middleName: new FormControl('', [
      Validators.required,
      Validators.pattern("[a-zA-Z]*$"),
    ]),
    relations_lastName: new FormControl('', [
      Validators.required,
      Validators.pattern("[a-zA-Z]*$"),
    ]),
    password: new FormControl('', [
      Validators.required,
      Validators.minLength(8),
    ]),
    date_of_birth: new FormControl('', [Validators.required]),
    gender: new FormControl('', [Validators.required]),
    mobileNumber: new FormControl('', [
      Validators.required,
      Validators.minLength(10),
      Validators.maxLength(10),
      Validators.pattern("^[0-9]*$"),
    ]),
    alternateContactNumber: new FormControl('', [
      Validators.minLength(10),
      Validators.maxLength(10),
      Validators.pattern("^[0-9]*$"),
    ]),
    email: new FormControl('', [
      Validators.email
    ]),
    address: new FormControl('', [Validators.required]),
    pincode: new FormControl('', [
      Validators.required,
      Validators.minLength(6),
      Validators.maxLength(6),
      Validators.pattern("^[0-9]*$")
    ])
  });

  navigateToHome(){
    this.route.navigateByUrl('');
  }

  PressOnlyNumbers(input: any) {
    var charCode = (input.which) ? input.which : input.keyCode;
    // Only Numbers 0-9
    if ((charCode < 48 || charCode > 57)) {
      input.preventDefault();
      return false;
    } else {
      return true;
    }
  }

  get registrationForm() {
    return this.registration_first_part.controls;
  }

  ngOnInit(): void {
    this.getUserDetails()
  }

  async getUserDetails(){
    this.spinner.show();
    await this.auth.getUser()
                .toPromise()
                .then((response) => {
                  const data: any = response;
                  console.log(data);
                  var is_user_known = new String(data.id)
                  this.is_update_valid = is_user_known.length
                  if (data != null || data.length > 0) {
                    this.db_user_identifier = data.id,
                    this.verifyRegistartion = data.is_submitted
                    this.registration_first_part.patchValue({
                      aadhaarNumber: data.aadhaarNo,
                      candidate_firstName: data.candidate_first_name,
                      candidate_middleName: data.candidate_middle_name,
                      candidate_lastName: data.candidate_last_name,
                      relation_name: data.relation,
                      relations_firstName: data.relations_first_name,
                      relations_middleName: data.relations_middle_name,
                      relations_lastName: data.relations_last_name,
                      password: "ravie@2020",
                      date_of_birth: data.dateofbirth,
                      gender: data.gender,
                      mobileNumber: data.phone_number,
                      alternateContactNumber: data.alternate_phone_number,
                      email: data.email,
                      address: data.address,
                      pincode: data.pincode,
                    });
                  }
                  if (this.verifyRegistartion == 1) {
                    this.is_submitted = true;
                  }
                  this.spinner.hide();
                })
                .catch((error) => {
                    Swal.fire({
                      icon: 'info',
                      title: 'Please Read Instructions Before You Fill',
                      text: 'IOGNORE If You Have Read',
                    });
                });
                this.spinner.hide();
  }

  async submit() {
    this.spinner.show();
    if (this.registration_first_part.valid) {
      await this.client.registrationPartOne(this.registration_first_part.value)
        .toPromise()
        .then((response) => {
          const data: any = response
          console.log(data)
          if (data.status == 'success') {
            Swal.fire({
              title: 'Registration of Stage 1',
              text: 'Completed Successfully, \n Please Login Using Your \n MobileNumber And Password To Continue Registration',
              icon: 'success',
              showConfirmButton: true,
              confirmButtonColor: '#2196f3',
              confirmButtonText: 'Ok',
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
  }

  async logout(){
    await this.auth.logout();
  }

  async next(){
    this.spinner.show();
    if (this.registration_first_part.valid) {
      await this.client.registrationPartOneUpdate(this.db_user_identifier, this.registration_first_part.value)
        .toPromise()
        .then((response) => {
          const data: any = response
          console.log(data)
          if (data.status == 'success') {
            this.route.navigateByUrl('registration-step-2');
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

}