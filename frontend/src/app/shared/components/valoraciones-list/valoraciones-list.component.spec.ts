import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ValoracionesListComponent } from './valoraciones-list.component';

describe('ValoracionesListComponent', () => {
  let component: ValoracionesListComponent;
  let fixture: ComponentFixture<ValoracionesListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ValoracionesListComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ValoracionesListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
