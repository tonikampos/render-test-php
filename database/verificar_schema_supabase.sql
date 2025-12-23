-- =========================================================================
-- SCRIPT DE VERIFICACIÓN: Comparar schema local vs Supabase
-- Ejecutar en: Supabase SQL Editor
-- Propósito: Obtener estructura completa de BD para comparar con schema.sql
-- =========================================================================

-- 1. TABLAS EXISTENTES
SELECT 
    'TABLA' as tipo,
    table_name as nombre,
    NULL as detalle
FROM information_schema.tables 
WHERE table_schema = 'public' 
  AND table_type = 'BASE TABLE'
ORDER BY table_name;

-- 2. COLUMNAS DE CADA TABLA
SELECT 
    'COLUMNA' as tipo,
    table_name,
    column_name,
    data_type,
    is_nullable,
    column_default
FROM information_schema.columns
WHERE table_schema = 'public'
ORDER BY table_name, ordinal_position;

-- 3. ÍNDICES
SELECT
    'INDICE' as tipo,
    schemaname,
    tablename,
    indexname,
    indexdef
FROM pg_indexes
WHERE schemaname = 'public'
ORDER BY tablename, indexname;

-- 4. FOREIGN KEYS (Claves foráneas)
SELECT
    'FK' as tipo,
    tc.table_name,
    kcu.column_name,
    ccu.table_name AS foreign_table_name,
    ccu.column_name AS foreign_column_name,
    tc.constraint_name
FROM information_schema.table_constraints AS tc
JOIN information_schema.key_column_usage AS kcu
    ON tc.constraint_name = kcu.constraint_name
    AND tc.table_schema = kcu.table_schema
JOIN information_schema.constraint_column_usage AS ccu
    ON ccu.constraint_name = tc.constraint_name
    AND ccu.table_schema = tc.table_schema
WHERE tc.constraint_type = 'FOREIGN KEY'
  AND tc.table_schema = 'public'
ORDER BY tc.table_name;

-- 5. TIPOS ENUM
SELECT
    'ENUM' as tipo,
    t.typname as enum_name,
    string_agg(e.enumlabel, ', ' ORDER BY e.enumsortorder) as valores
FROM pg_type t
JOIN pg_enum e ON t.oid = e.enumtypid
JOIN pg_catalog.pg_namespace n ON n.oid = t.typnamespace
WHERE n.nspname = 'public'
GROUP BY t.typname
ORDER BY t.typname;

-- 6. VISTAS
SELECT
    'VISTA' as tipo,
    table_name as nombre,
    view_definition as definicion
FROM information_schema.views
WHERE table_schema = 'public'
ORDER BY table_name;

-- 7. EXTENSIONES
SELECT
    'EXTENSION' as tipo,
    extname as nombre,
    extversion as version
FROM pg_extension
WHERE extname NOT IN ('plpgsql') -- Excluir extensiones por defecto
ORDER BY extname;

-- 8. RESUMEN DE DIFERENCIAS COMUNES
SELECT
    'RESUMEN' as tipo,
    'Total tablas' as categoria,
    COUNT(*)::text as valor
FROM information_schema.tables 
WHERE table_schema = 'public' 
  AND table_type = 'BASE TABLE'
UNION ALL
SELECT
    'RESUMEN',
    'Total índices',
    COUNT(*)::text
FROM pg_indexes
WHERE schemaname = 'public'
UNION ALL
SELECT
    'RESUMEN',
    'Total foreign keys',
    COUNT(*)::text
FROM information_schema.table_constraints
WHERE constraint_type = 'FOREIGN KEY'
  AND table_schema = 'public'
UNION ALL
SELECT
    'RESUMEN',
    'Total enums',
    COUNT(DISTINCT typname)::text
FROM pg_type t
JOIN pg_catalog.pg_namespace n ON n.oid = t.typnamespace
WHERE n.nspname = 'public'
  AND t.typtype = 'e';

-- =========================================================================
-- VERIFICACIONES ESPECÍFICAS DE TU APLICACIÓN
-- =========================================================================

-- 9. Verificar índice GIN pg_trgm (de optimización reciente)
SELECT 
    CASE 
        WHEN EXISTS (
            SELECT 1 FROM pg_indexes 
            WHERE indexname = 'idx_habilidades_titulo_trgm'
        ) THEN '✅ idx_habilidades_titulo_trgm existe'
        ELSE '❌ idx_habilidades_titulo_trgm NO existe'
    END as titulo_index,
    CASE 
        WHEN EXISTS (
            SELECT 1 FROM pg_indexes 
            WHERE indexname = 'idx_habilidades_descripcion_trgm'
        ) THEN '✅ idx_habilidades_descripcion_trgm existe'
        ELSE '❌ idx_habilidades_descripcion_trgm NO existe (ejecutar optimizacion_indice_busqueda.sql)'
    END as descripcion_index;

-- 10. Verificar extensión pg_trgm
SELECT 
    CASE 
        WHEN EXISTS (SELECT 1 FROM pg_extension WHERE extname = 'pg_trgm')
        THEN '✅ Extensión pg_trgm instalada'
        ELSE '❌ Extensión pg_trgm NO instalada'
    END as status;

-- =========================================================================
-- INSTRUCCIONES:
-- 1. Copia todo este script
-- 2. Pega en Supabase → SQL Editor
-- 3. Ejecuta (Run)
-- 4. Guarda resultados en archivo de texto
-- 5. Compara con schema.sql línea por línea
-- =========================================================================
