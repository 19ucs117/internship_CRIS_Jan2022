import { ComponentFixture, TestBed } from '@angular/core/testing';

import { StageTwoFormComponent } from './stage-two-form.component';

describe('StageTwoFormComponent', () => {
  let component: StageTwoFormComponent;
  let fixture: ComponentFixture<StageTwoFormComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ StageTwoFormComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(StageTwoFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
