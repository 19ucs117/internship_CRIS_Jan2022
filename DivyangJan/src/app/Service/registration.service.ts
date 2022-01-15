import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class RegistrationService {

  constructor(private api: HttpClient) { }

  registrationPartOne(data: any) {
    return this.api.post(environment.base_url + '/registrationPartOne', data);
  }

  registrationPartOneUpdate(id: any, data: any) {
    return this.api.put(environment.base_url + '/UPDATEregistrationPartOne/' + id, data);
  }

  registrationPartTwo(data: any) {
    return this.api.post(environment.base_url + '/registrationPartTwo', data);
  }

  registrationPartTwoRead(data: any) {
    return this.api.get(environment.base_url + '/READregistrationPartTwo/' + data);
  }

  registrationPartTwoUpdate(id: any, data: any) {
    return this.api.put(environment.base_url + '/UPDATEregistrationPartTwo/'+ id, data);
  }

  registrationPartThree(data: any) {
    return this.api.post(environment.base_url + '/registrationPartThree', data);
  }

  registrationPartThreeRead(data: any) {
    return this.api.get(environment.base_url + '/READregistrationPartThree/'+ data);
  }

  update_RailwayConcessionCertificate(data: any) {
    return this.api.post(environment.base_url + '/update_RailwayConcessionCertificate/', data);
  }

  update_DisabilityCertificate(data: any) {
    return this.api.post(environment.base_url + '/update_DisabilityCertificate/', data);
  }

  update_AgeCertificate(data: any) {
    return this.api.post(environment.base_url + '/update_AgeCertificate/', data);
  }

  update_AadhaarCard(data: any) {
    return this.api.post(environment.base_url + '/update_AadhaarCard/', data);
  }

  update_AddressProof(data: any) {
    return this.api.post(environment.base_url + '/update_AddressProof/', data);
  }

  update_PassportsizePhoto(data: any) {
    return this.api.post(environment.base_url + '/update_PassportsizePhoto/', data);
  }

  registartion_Submission() {
    return this.api.get(environment.base_url + '/registartionCOMPLETION');
  }
  




}
