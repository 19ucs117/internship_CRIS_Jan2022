import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { RegistrationFormsComponent } from './registration-forms/registration-forms.component';
import { InstructionsComponent } from './instructions/instructions.component';
import { HomeComponent } from './home/home.component';
import { StageTwoFormComponent } from './registration-forms/stage-two-form/stage-two-form.component';
import { StageThreeFormComponent } from './registration-forms/stage-three-form/stage-three-form.component';

const routes: Routes = [
  {
    path: '',
    component: HomeComponent
  },
  {
    path: 'registration',
    component: RegistrationFormsComponent
  },
  {
    path: 'instructions',
    component: InstructionsComponent
  },
  {
    path: 'registration-step-2',
    component: StageTwoFormComponent
  },
  {
    path: 'registration-step-3',
    component: StageThreeFormComponent
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
