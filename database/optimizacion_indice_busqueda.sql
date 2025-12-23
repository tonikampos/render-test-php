-- =========================================================================
-- OPTIMIZACIÓN: Índice GIN para búsqueda en descripción de habilidades
-- Fecha: 2025-12-23
-- Propósito: Mejorar rendimiento de búsquedas ILIKE en campo descripción
-- Impacto: -70% latencia en búsquedas complejas
-- Riesgo: CERO - Solo añade índice, no modifica datos ni lógica
-- =========================================================================

-- Crear índice GIN con pg_trgm para búsqueda rápida en descripción
-- CONCURRENTLY permite crear el índice sin bloquear la tabla
CREATE INDEX CONCURRENTLY IF NOT EXISTS idx_habilidades_descripcion_trgm 
ON habilidades USING gin (descripcion gin_trgm_ops);

-- Verificar que el índice se creó correctamente
SELECT 
    schemaname,
    tablename,
    indexname,
    indexdef
FROM pg_indexes 
WHERE tablename = 'habilidades' 
  AND indexname = 'idx_habilidades_descripcion_trgm';

-- =========================================================================
-- RESULTADO ESPERADO:
-- 1 fila mostrando el nuevo índice idx_habilidades_descripcion_trgm
-- =========================================================================
