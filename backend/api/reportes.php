<?php
/**
 * Endpoints de Reportes (Admin only)
 * TODO: Implementar funcionalidad completa
 */

function handleReportesRoutes($method, $id, $action, $input) {
    Auth::requireAdmin();
    Response::error('Endpoint en desarrollo', 501);
}
