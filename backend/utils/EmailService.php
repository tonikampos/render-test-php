<?php
/**
 * Servicio de envío de emails
 * Integración con Resend
 * 
 * CONFIGURACIÓN REQUERIDA:
 * - Variable de entorno: RESEND_API_KEY
 * - Variable de entorno: FRONTEND_URL
 * 
 * Para Resend:
 * 1. Crear cuenta en https://resend.com
 * 2. Obtener API Key en: API Keys → Create API Key
 * 3. (Opcional) Añadir dominio propio para emails profesionales
 * 
 * Plan gratuito: 3,000 emails/mes + 100 emails/día
 */

class EmailService {
    
    /**
     * Enviar email de recuperación de contraseña
     * 
     * @param string $email Email del destinatario
     * @param string $token Token de recuperación
     * @return bool True si se envió correctamente
     */
    public static function enviarRecuperacionPassword($email, $token) {
        try {
            // Obtener configuración
            $resend_api_key = getenv('RESEND_API_KEY');
            $frontend_url = getenv('FRONTEND_URL') ?: 'http://localhost:4200';
            
            // Si no hay API key, modo desarrollo (solo log)
            if (empty($resend_api_key)) {
                error_log("=== MODO DESARROLLO - EMAIL NO ENVIADO ===");
                error_log("Destinatario: $email");
                error_log("Token: $token");
                error_log("Link de recuperación: $frontend_url/reset-password?token=$token");
                error_log("===========================================");
                return true; // En desarrollo, consideramos éxito
            }
            
            // URL del enlace de recuperación
            $reset_link = "$frontend_url/reset-password?token=$token";
            
            // Contenido HTML del email
            $html_content = self::getEmailTemplate($reset_link);
            
            // Preparar datos para Resend API
            // NOTA: Usa 'onboarding@resend.dev' para testing o tu dominio verificado
            $from_email = getenv('RESEND_FROM_EMAIL') ?: 'onboarding@resend.dev';
            
            $data = [
                'from' => "GaliTroco <$from_email>",
                'to' => [$email],
                'subject' => 'Recuperación de Contraseña - GaliTroco',
                'html' => $html_content
            ];
            
            // Enviar email mediante API de Resend
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, 'https://api.resend.com/emails');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $resend_api_key,
                'Content-Type: application/json'
            ]);
            
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            // Verificar respuesta
            if ($http_code >= 200 && $http_code < 300) {
                error_log("Email de recuperación enviado exitosamente a: $email");
                return true;
            } else {
                error_log("Error enviando email. HTTP Code: $http_code, Response: $response");
                return false;
            }
            
        } catch (Exception $e) {
            error_log("Excepción al enviar email: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Template HTML del email de recuperación
     * 
     * @param string $reset_link Enlace de recuperación
     * @return string HTML del email
     */
    private static function getEmailTemplate($reset_link) {
        return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Recuperación de Contraseña</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #f5f5f5;
                    line-height: 1.6;
                    color: #333333;
                }
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                }
                .header {
                    background: linear-gradient(135deg, #3f51b5 0%, #5c6bc0 100%);
                    color: #ffffff;
                    padding: 40px 20px;
                    text-align: center;
                }
                .header h1 {
                    margin: 0;
                    font-size: 28px;
                    font-weight: 600;
                }
                .header .icon {
                    font-size: 48px;
                    margin-bottom: 10px;
                }
                .content {
                    padding: 40px 30px;
                    background-color: #ffffff;
                }
                .content p {
                    margin: 0 0 15px 0;
                    font-size: 16px;
                    color: #555555;
                }
                .content .greeting {
                    font-size: 18px;
                    font-weight: 600;
                    color: #333333;
                    margin-bottom: 20px;
                }
                .button-container {
                    text-align: center;
                    margin: 35px 0;
                }
                .reset-button {
                    display: inline-block;
                    padding: 14px 40px;
                    background: linear-gradient(135deg, #3f51b5 0%, #5c6bc0 100%);
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 5px;
                    font-weight: 600;
                    font-size: 16px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    transition: transform 0.2s;
                }
                .reset-button:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
                }
                .link-box {
                    background-color: #f9f9f9;
                    border: 1px solid #e0e0e0;
                    border-radius: 5px;
                    padding: 15px;
                    margin: 20px 0;
                    word-break: break-all;
                    font-size: 13px;
                    color: #666666;
                }
                .expiration-notice {
                    background-color: #fff3cd;
                    border-left: 4px solid #ffc107;
                    padding: 15px;
                    margin: 25px 0;
                    border-radius: 4px;
                }
                .expiration-notice strong {
                    color: #856404;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }
                .expiration-notice .icon {
                    font-size: 20px;
                }
                .security-note {
                    background-color: #e3f2fd;
                    border-left: 4px solid #2196F3;
                    padding: 15px;
                    margin: 20px 0;
                    border-radius: 4px;
                    font-size: 14px;
                }
                .footer {
                    background-color: #f5f5f5;
                    padding: 30px 20px;
                    text-align: center;
                    border-top: 1px solid #e0e0e0;
                }
                .footer p {
                    margin: 5px 0;
                    font-size: 13px;
                    color: #777777;
                }
                .footer .copyright {
                    font-weight: 600;
                    color: #555555;
                }
                .footer .no-reply {
                    font-style: italic;
                    color: #999999;
                    margin-top: 15px;
                }
            </style>
        </head>
        <body>
            <div class='email-container'>
                
                <!-- Header -->
                <div class='header'>
                    <div class='icon'>🔐</div>
                    <h1>Recuperación de Contraseña</h1>
                </div>
                
                <!-- Content -->
                <div class='content'>
                    <p class='greeting'>¡Hola!</p>
                    
                    <p>
                        Has solicitado restablecer tu contraseña en <strong>GaliTroco</strong>, 
                        la plataforma de intercambio de habilidades.
                    </p>
                    
                    <p>
                        Para crear una nueva contraseña, haz click en el siguiente botón:
                    </p>
                    
                    <div class='button-container'>
                        <a href='$reset_link' class='reset-button'>
                            Restablecer Mi Contraseña
                        </a>
                    </div>
                    
                    <p>
                        Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:
                    </p>
                    
                    <div class='link-box'>
                        $reset_link
                    </div>
                    
                    <div class='expiration-notice'>
                        <strong>
                            <span class='icon'>⏰</span>
                            Este enlace expirará en 1 hora por seguridad.
                        </strong>
                    </div>
                    
                    <div class='security-note'>
                        <strong>🔒 Nota de Seguridad:</strong><br>
                        Si no solicitaste este cambio de contraseña, puedes ignorar este email. 
                        Tu cuenta permanecerá segura.
                    </div>
                </div>
                
                <!-- Footer -->
                <div class='footer'>
                    <p class='copyright'>
                        © 2025 <strong>GaliTroco</strong> - Plataforma de Intercambio de Habilidades
                    </p>
                    <p>
                        Conectando personas, compartiendo conocimientos
                    </p>
                    <p class='no-reply'>
                        Este es un email automático, por favor no respondas a este mensaje.
                    </p>
                </div>
                
            </div>
        </body>
        </html>
        ";
    }
    
    /**
     * Enviar email de bienvenida (opcional - futuro)
     * 
     * @param string $email Email del nuevo usuario
     * @param string $nombre Nombre del usuario
     * @return bool
     */
    public static function enviarBienvenida($email, $nombre) {
        // TODO: Implementar cuando sea necesario
        return true;
    }
    
    /**
     * Enviar notificación de nuevo mensaje (opcional - futuro)
     * 
     * @param string $email Email del destinatario
     * @param string $remitente Nombre del remitente
     * @return bool
     */
    public static function enviarNotificacionMensaje($email, $remitente) {
        // TODO: Implementar cuando sea necesario
        return true;
    }
}

