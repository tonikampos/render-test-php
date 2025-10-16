import { ComponentFixture, TestBed } from '@angular/core/testing';

import { IntercambiosListComponent } from './intercambios-list.component';

describe('IntercambiosListComponent', () => {
  let component: IntercambiosListComponent;
  let fixture: ComponentFixture<IntercambiosListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [IntercambiosListComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(IntercambiosListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
