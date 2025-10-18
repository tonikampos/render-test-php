import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ReportarDialogComponent } from './reportar-dialog.component';

describe('ReportarDialogComponent', () => {
  let component: ReportarDialogComponent;
  let fixture: ComponentFixture<ReportarDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ReportarDialogComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ReportarDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
