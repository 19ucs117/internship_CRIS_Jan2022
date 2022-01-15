import { ComponentFixture, TestBed } from '@angular/core/testing';

import { StageThreeFormComponent } from './stage-three-form.component';

describe('StageThreeFormComponent', () => {
  let component: StageThreeFormComponent;
  let fixture: ComponentFixture<StageThreeFormComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ StageThreeFormComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(StageThreeFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
