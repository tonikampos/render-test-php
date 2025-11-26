-- Migración: Actualizar ENUM estado_reporte para incluir 'desestimado' y 'accion_tomada'
-- Fecha: 2025-11-26

-- En PostgreSQL, ALTER TYPE ADD VALUE solo añade valores, no modifica los existentes
-- Añadimos los nuevos valores al ENUM

ALTER TYPE estado_reporte ADD VALUE IF NOT EXISTS 'desestimado';
ALTER TYPE estado_reporte ADD VALUE IF NOT EXISTS 'accion_tomada';

-- Nota: Si necesitamos eliminar 'resuelto' (que ya no se usa), tendríamos que:
-- 1. Crear un nuevo tipo
-- 2. Migrar los datos
-- 3. Eliminar el tipo antiguo
-- Por ahora, solo añadimos los nuevos valores y dejamos 'resuelto' por compatibilidad
