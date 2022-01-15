import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { RegistrationService } from 'src/app/Service/registration.service';
import { AuthService } from 'src/app/Service/auth.service';
import { Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import Swal from 'sweetalert2';
declare var $: any

@Component({
  selector: 'app-stage-two-form',
  templateUrl: './stage-two-form.component.html',
  styleUrls: ['./stage-two-form.component.sass']
})
export class StageTwoFormComponent implements OnInit {

  registration_second_part = new FormGroup({
    handicapped_person_id: new FormControl('', ),
    disability_certificate_number: new FormControl('', Validators.required),
    nature_of_disability: new FormControl('', Validators.required),
    type_of_category: new FormControl('', Validators.required),
    railway_concession_certificate_issuing_hospital: new FormControl('', Validators.required),
    hospital_address: new FormControl('', Validators.required),
    doctor_name: new FormControl('', Validators.required),
    doctor_registration_no: new FormControl('', Validators.required),
    date_of_issue_concession_certificate: new FormControl('', Validators.required)
  });

  db_user_identifier: any;
  user_identifier: any;
  part_two_registration_data: any;
  is_update_valid: number = 0;
  is_submitted: boolean = false;
  verifyRegistartion: any

  constructor(private client: RegistrationService, private auth: AuthService, private route: Router, private spinner: NgxSpinnerService) { }

  ngOnInit(): void {
    this.getUserDetails()
  }

  get registrationFormSecondStage(){
    return this.registration_second_part.controls;
  }

  async getUserDetails() {
    this.spinner.show();
    await this.auth.getUser()
      .toPromise()
      .then((response) => {
        const data: any = response;
        console.log(data);
        this.verifyRegistartion = data.is_submitted
        this.db_user_identifier = data.id
        this.registration_part_two_read(this.db_user_identifier)
        this.spinner.hide();
      })
      .catch((error) => {
        if (localStorage.getItem('ACCESS_TOKEN') != null) {
          console.log(localStorage.getItem('ACCESS_TOKEN'))
          Swal.fire({
            icon: 'error',
            title: 'Session Expired',
            text: 'LoginIn Time Out',
          });
        }
        else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please Login Again',
          });
        }
      });
    this.spinner.hide();
  }

  async registration_part_two_read(id: any) {
    this.spinner.show();
    await this.client.registrationPartTwoRead(id)
      .toPromise()
      .then((response) => {
        const data: any = response;
        var is_user_known = new String(data[0].id)
        this.is_update_valid = is_user_known.length
        console.log(this.is_update_valid)
        this.user_identifier = data[0].id;
        this.registration_second_part.patchValue({
          disability_certificate_number: data[0].disability_certificate_number,
          nature_of_disability: data[0].nature_of_disability,
          type_of_category: data[0].type_of_category,
          railway_concession_certificate_issuing_hospital: data[0].railway_concession_certificate_issuing_hospital,
          hospital_address: data[0].hospital_address,
          doctor_name: data[0].name_of_doctor,
          doctor_registration_no: data[0].registration_number_of_doctor,
          date_of_issue_concession_certificate: data[0].date_of_issue_of_concession_certificate,
        });
        if (this.verifyRegistartion == 1) {
          this.is_submitted = true;
        }
        console.log(data)
        this.spinner.hide();
      })
      .catch((error) => {
        if (localStorage.getItem('ACCESS_TOKEN') != null) {
          console.log(localStorage.getItem('ACCESS_TOKEN'))
          Swal.fire({
            icon: 'warning',
            title: 'Registration Validit Only 72Hrs',
            text: 'So Must Complete Registration Else Data Erased Permanently',
          });
        }
        else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please Login Again',
          });
          this.route.navigateByUrl('');
        }
      });
    this.spinner.hide();
  }

  previous() {
    this.route.navigateByUrl('registration');
  }

  async next() {
    console.log(this.user_identifier, this.registration_second_part.value);
    this.spinner.show();
    if (this.registration_second_part.valid) {
      await this.client.registrationPartTwoUpdate(this.user_identifier, this.registration_second_part.value)
        .toPromise()
        .then((response) => {
          const data: any = response
          console.log(data)
          if (data.status == 'success') {
            this.route.navigateByUrl('registration-step-3');
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

  async submit() {
    this.spinner.show();
    if (this.registration_second_part.valid) {
      this.registration_second_part.patchValue({
        handicapped_person_id: this.db_user_identifier,
      });
      await this.client.registrationPartTwo(this.registration_second_part.value)
        .toPromise()
        .then((response) => {
          const data: any = response
          console.log(data)
          if (data.status == 'success') {
            Swal.fire({
              title: 'Registration of Stage 2',
              text: 'Completed Successfully',
              icon: 'success',
              showConfirmButton: true,
              confirmButtonColor: '#2196f3',
              confirmButtonText: 'Ok',
            });
            this.route.navigateByUrl('registration-step-3');
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

  async logout() {
    await this.auth.logout();
  }

}
