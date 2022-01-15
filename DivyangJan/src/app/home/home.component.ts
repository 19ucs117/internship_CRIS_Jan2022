import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { AuthService } from "src/app/Service/auth.service";
import { NgxSpinnerService } from 'ngx-spinner';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';
declare var $ : any;

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.sass']
})
export class HomeComponent implements OnInit {

  loginForm = new FormGroup({
    phone_number: new FormControl('', Validators.required),
    password: new FormControl('', Validators.required)
  });

  constructor(private auth: AuthService, private spinner: NgxSpinnerService, private route: Router) { }

  ngOnInit(): void {
    
  }

  letter_size: number = 20;
  zoom: number = 0;

  get loginForm_controls() {
    return this.loginForm.controls;
  }

  zoom_in(){
    this.zoom = this.letter_size + 10;
    document.body.style.fontSize = this.zoom.toString() + "px";
  }

  zoom_out(){
    this.zoom = this.letter_size - 10;
    document.body.style.fontSize = this.zoom.toString() + "px";
  }

  showNav(){
    $(this).toggleClass('click');
    $('.navbar').toggleClass('show');
  }
      

  async login() {
    if (this.loginForm.valid) {
      this.spinner.show();
      const response: any = await this.auth
        .login(this.loginForm.value)
        .toPromise()
        .catch((err) => {
          Swal.fire('Error', err.message, 'error');
          this.spinner.hide();
        });
      if (response.access_token) {
        await Promise.resolve().then(() => {
          localStorage.setItem('ACCESS_TOKEN', response.access_token);
        });
        this.route.navigateByUrl('registration');
      } else {
        Swal.fire('Error', response.error, 'error');
      }
      this.spinner.hide();
    }
  }

  navigateToHome(){
    this.route.navigateByUrl('');
  }

}
