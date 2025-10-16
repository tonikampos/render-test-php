import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProponerIntercambioDialogComponent } from './proponer-intercambio-dialog.component';

describe('ProponerIntercambioDialogComponent', () => {
  let component: ProponerIntercambioDialogComponent;
  let fixture: ComponentFixture<ProponerIntercambioDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ProponerIntercambioDialogComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProponerIntercambioDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
