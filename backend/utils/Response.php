<?php
/**
 * Clase para gestionar respuestas JSON de la API
 * Proporciona métodos estáticos para enviar respuestas consistentes
 */

class Response {
    
    /**
     * Enviar respuesta exitosa
     */
    public static function success($data = null, $message = 'OK', $code = 200) {
        http_response_code($code);
        
        $response = [
            'success' => true,
            'message' => $message
        ];
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    /**
     * Enviar respuesta de error
     */
    public static function error($message = 'Error', $code = 400, $details = null) {
        http_response_code($code);
        
        $response = [
            'success' => false,
            'message' => $message
        ];
        
        if ($details !== null) {
            $response['details'] = $details;
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    /**
     * Respuesta de validación fallida
     */
    public static function validationError($errors) {
        self::error('Errores de validación', 422, $errors);
    }
    
    /**
     * Respuesta de no autenticado
     */
    public static function unauthorized($message = 'No autenticado') {
        self::error($message, 401);
    }
    
    /**
     * Respuesta de prohibido (sin permisos)
     */
    public static function forbidden($message = 'No tienes permisos') {
        self::error($message, 403);
    }
    
    /**
     * Respuesta de no encontrado
     */
    public static function notFound($message = 'Recurso no encontrado') {
        self::error($message, 404);
    }
    
    /**
     * Respuesta de error del servidor
     */
    public static function serverError($message = 'Error del servidor', $details = null) {
        // Log del error
        if ($details) {
            error_log("Server Error: $message - " . json_encode($details));
        }
        
        // En producción, no mostrar detalles internos
        $isProduction = getenv('ENVIRONMENT') === 'production';
        
        self::error(
            $message, 
            500, 
            $isProduction ? null : $details
        );
    }
    
    /**
     * Respuesta de método no permitido
     */
    public static function methodNotAllowed($allowedMethods = []) {
        if (!empty($allowedMethods)) {
            header('Allow: ' . implode(', ', $allowedMethods));
        }
        self::error('Método HTTP no permitido', 405);
    }
    
    /**
     * Respuesta de creación exitosa
     */
    public static function created($data = null, $message = 'Recurso creado exitosamente') {
        self::success($data, $message, 201);
    }
    
    /**
     * Respuesta de eliminación exitosa
     */
    public static function deleted($message = 'Recurso eliminado exitosamente') {
        self::success(null, $message, 200);
    }
    
    /**
     * Respuesta paginada
     */
    public static function paginated($items, $total, $page, $perPage, $message = 'OK') {
        $totalPages = ceil($total / $perPage);
        
        $data = [
            'items' => $items,
            'pagination' => [
                'total' => (int)$total,
                'per_page' => (int)$perPage,
                'current_page' => (int)$page,
                'total_pages' => $totalPages,
                'has_next' => $page < $totalPages,
                'has_prev' => $page > 1
            ]
        ];
        
        self::success($data, $message);
    }
}
