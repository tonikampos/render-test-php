import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ResolverReporteDialogComponent } from './resolver-reporte-dialog.component';

describe('ResolverReporteDialogComponent', () => {
  let component: ResolverReporteDialogComponent;
  let fixture: ComponentFixture<ResolverReporteDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ResolverReporteDialogComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ResolverReporteDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
