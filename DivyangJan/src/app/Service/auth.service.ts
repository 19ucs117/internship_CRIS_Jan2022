import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Router } from '@angular/router';
import { environment } from 'src/environments/environment';
import Swal from 'sweetalert2';
@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private api: HttpClient, private route: Router) { }


  getToken(){
    if (localStorage.getItem('ACCESS_TOKEN') != '') {
      return localStorage.getItem('ACCESS_TOKEN');
    }
    return null;
  }

  login(data: any) {
    return this.api.post(environment.base_url + '/auth/login', data);
  }

  getUser() {
    return this.api.post(environment.base_url + '/auth/me', '');
  }

  async is_LoggedIn() {
    var response: any = await this.api
      .post(environment.base_url + '/auth/isLogin', '')
      .toPromise()
      .catch((e) => {
        Swal.fire('Error', e.message, 'error');
        return false;
      });
    if (await response.status) {
      return true;

    }
    else{
      localStorage.removeItem('ACCESS_TOKEN');
      localStorage.removeItem('USER');
      this.route.navigateByUrl('');
      return false;
    }
  }

  async logout() {
    var response: any = await this.api
      .post(environment.base_url + '/auth/logout', '')
      .toPromise()
      .catch((e) => {
        Swal.fire('Error', e.message, 'error');
      });
    if (response.status == true) {
      localStorage.removeItem('ACCESS_TOKEN');
      localStorage.removeItem('USER');
      this.route.navigateByUrl('');
    } else {
      localStorage.removeItem('ACCESS_TOKEN');
      localStorage.removeItem('USER');
      this.route.navigateByUrl('');
    }
  }
}
