-- =========================================================================
-- EXPORTAR SCHEMA COMPLETO DE SUPABASE (SIMPLE)
-- Ejecutar en: Supabase SQL Editor
-- =========================================================================

-- Obtener DDL completo de todas las tablas
SELECT 
    'CREATE TABLE ' || table_name || ' (' || 
    string_agg(
        column_name || ' ' || 
        data_type || 
        CASE WHEN character_maximum_length IS NOT NULL 
             THEN '(' || character_maximum_length || ')' 
             ELSE '' END ||
        CASE WHEN is_nullable = 'NO' THEN ' NOT NULL' ELSE '' END ||
        CASE WHEN column_default IS NOT NULL 
             THEN ' DEFAULT ' || column_default 
             ELSE '' END,
        ', '
    ) || ');' as create_statement
FROM information_schema.columns
WHERE table_schema = 'public'
GROUP BY table_name
ORDER BY table_name;

-- Lista simple de índices
SELECT indexname, indexdef 
FROM pg_indexes 
WHERE schemaname = 'public'
ORDER BY indexname;
