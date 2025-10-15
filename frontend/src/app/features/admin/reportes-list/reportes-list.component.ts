import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReportesService } from '../../../core/services/reportes.service';
import { Reporte } from '../../../shared/models/reporte.model';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-reportes-list',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './reportes-list.component.html',
  styleUrls: ['./reportes-list.component.scss']
})
export class ReportesListComponent implements OnInit {
  reportes: Reporte[] = [];

  constructor(private reportesService: ReportesService) {}

  ngOnInit(): void {
    this.cargarReportes();
  }

  cargarReportes(): void {
    this.reportesService.getReportesPendientes().subscribe(res => {
      if (res.success && res.data) {
        this.reportes = res.data;
      }
    });
  }

  resolver(reporteId: number): void {
    const notas = "O reporte foi revisado e o contido correspondente foi eliminado.";
    this.reportesService.resolverReporte(reporteId, 'accion_tomada', notas).subscribe({
      next: (res) => {
        if (res.success) {
          // Elimina o reporte da lista para que desapareza da vista
          this.reportes = this.reportes.filter(r => r.id !== reporteId);
          alert('Reporte resolto con éxito!');
        }
      },
      error: (err) => {
        alert('Erro ao resolver o reporte: ' + err.message);
      }
    });
  }
}