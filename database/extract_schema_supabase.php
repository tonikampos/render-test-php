<?php
/**
 * SCRIPT DE EXTRACCIÓN DE ESQUEMA DESDE SUPABASE
 * Genera automáticamente los scripts SQL de creación y carga de datos
 */

require_once __DIR__ . '/../backend/config/database.php';

echo "=============================================================\n";
echo "   EXTRACTOR DE ESQUEMA Y DATOS - SUPABASE → SQL\n";
echo "=============================================================\n\n";

try {
    $conn = Database::getConnection();
    echo "✅ Conexión exitosa a Supabase\n\n";
    
    // =========================================================================
    // PASO 1: EXTRAER TIPOS ENUM
    // =========================================================================
    echo "📋 Paso 1/5: Extrayendo tipos ENUM...\n";
    
    $sql_enums = "-- =========================================================================\n";
    $sql_enums .= "-- TIPOS ENUMERADOS (ENUM)\n";
    $sql_enums .= "-- =========================================================================\n\n";
    
    $query_enums = "
        SELECT t.typname as enum_name, 
               array_agg(e.enumlabel ORDER BY e.enumsortorder) as enum_values
        FROM pg_type t 
        JOIN pg_enum e ON t.oid = e.enumtypid  
        JOIN pg_catalog.pg_namespace n ON n.oid = t.typnamespace
        WHERE n.nspname = 'public'
        GROUP BY t.typname
        ORDER BY t.typname;
    ";
    
    $stmt = $conn->query($query_enums);
    $enums = $stmt->fetchAll();
    
    foreach ($enums as $enum) {
        $values = str_replace(['{', '}'], '', $enum['enum_values']);
        $values = implode("', '", explode(',', $values));
        $sql_enums .= "CREATE TYPE {$enum['enum_name']} AS ENUM ('{$values}');\n";
    }
    
    echo "   ✅ {count($enums)} tipos ENUM encontrados\n\n";
    
    // =========================================================================
    // PASO 2: EXTRAER ESTRUCTURA DE TABLAS
    // =========================================================================
    echo "📋 Paso 2/5: Extrayendo estructura de tablas...\n";
    
    $sql_tables = "\n-- =========================================================================\n";
    $sql_tables .= "-- TABLAS\n";
    $sql_tables .= "-- =========================================================================\n\n";
    
    // Obtener lista de tablas
    $query_tables = "
        SELECT table_name 
        FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_type = 'BASE TABLE'
        ORDER BY table_name;
    ";
    
    $stmt = $conn->query($query_tables);
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "   ✅ " . count($tables) . " tablas encontradas: " . implode(', ', $tables) . "\n\n";
    
    foreach ($tables as $table) {
        // Obtener definición completa de cada tabla
        $query_create = "
            SELECT 
                'CREATE TABLE ' || table_name || ' (' || 
                string_agg(
                    column_name || ' ' || 
                    CASE 
                        WHEN data_type = 'USER-DEFINED' THEN udt_name
                        WHEN data_type = 'character varying' THEN 'VARCHAR(' || character_maximum_length || ')'
                        WHEN data_type = 'character' THEN 'CHAR(' || character_maximum_length || ')'
                        ELSE UPPER(data_type)
                    END ||
                    CASE WHEN is_nullable = 'NO' THEN ' NOT NULL' ELSE '' END ||
                    CASE WHEN column_default IS NOT NULL THEN ' DEFAULT ' || column_default ELSE '' END,
                    ', ' ORDER BY ordinal_position
                ) || 
                ');' as create_table
            FROM information_schema.columns
            WHERE table_schema = 'public' AND table_name = :table
            GROUP BY table_name;
        ";
        
        $stmt = $conn->prepare($query_create);
        $stmt->execute(['table' => $table]);
        $create_def = $stmt->fetch();
        
        $sql_tables .= "-- Tabla: {$table}\n";
        $sql_tables .= $create_def['create_table'] . "\n\n";
        
        // Obtener PRIMARY KEY
        $query_pk = "
            SELECT string_agg(column_name, ', ') as pk_columns
            FROM information_schema.table_constraints tc
            JOIN information_schema.key_column_usage kcu 
                ON tc.constraint_name = kcu.constraint_name
            WHERE tc.table_schema = 'public' 
            AND tc.table_name = :table
            AND tc.constraint_type = 'PRIMARY KEY';
        ";
        
        $stmt = $conn->prepare($query_pk);
        $stmt->execute(['table' => $table]);
        $pk = $stmt->fetch();
        
        if ($pk && $pk['pk_columns']) {
            $sql_tables .= "ALTER TABLE {$table} ADD PRIMARY KEY ({$pk['pk_columns']});\n\n";
        }
    }
    
    // =========================================================================
    // PASO 3: EXTRAER FOREIGN KEYS
    // =========================================================================
    echo "📋 Paso 3/5: Extrayendo relaciones (FOREIGN KEYS)...\n";
    
    $sql_fk = "-- =========================================================================\n";
    $sql_fk .= "-- FOREIGN KEYS\n";
    $sql_fk .= "-- =========================================================================\n\n";
    
    $query_fk = "
        SELECT 
            tc.table_name,
            tc.constraint_name,
            kcu.column_name,
            ccu.table_name AS foreign_table_name,
            ccu.column_name AS foreign_column_name,
            rc.update_rule,
            rc.delete_rule
        FROM information_schema.table_constraints AS tc 
        JOIN information_schema.key_column_usage AS kcu
            ON tc.constraint_name = kcu.constraint_name
        JOIN information_schema.constraint_column_usage AS ccu
            ON ccu.constraint_name = tc.constraint_name
        JOIN information_schema.referential_constraints AS rc
            ON tc.constraint_name = rc.constraint_name
        WHERE tc.constraint_type = 'FOREIGN KEY'
        AND tc.table_schema = 'public'
        ORDER BY tc.table_name, tc.constraint_name;
    ";
    
    $stmt = $conn->query($query_fk);
    $fks = $stmt->fetchAll();
    
    foreach ($fks as $fk) {
        $sql_fk .= "ALTER TABLE {$fk['table_name']}\n";
        $sql_fk .= "  ADD CONSTRAINT {$fk['constraint_name']}\n";
        $sql_fk .= "  FOREIGN KEY ({$fk['column_name']})\n";
        $sql_fk .= "  REFERENCES {$fk['foreign_table_name']}({$fk['foreign_column_name']})";
        
        if ($fk['delete_rule'] !== 'NO ACTION') {
            $sql_fk .= " ON DELETE {$fk['delete_rule']}";
        }
        if ($fk['update_rule'] !== 'NO ACTION') {
            $sql_fk .= " ON UPDATE {$fk['update_rule']}";
        }
        
        $sql_fk .= ";\n\n";
    }
    
    echo "   ✅ " . count($fks) . " foreign keys encontradas\n\n";
    
    // =========================================================================
    // PASO 4: EXTRAER ÍNDICES
    // =========================================================================
    echo "📋 Paso 4/5: Extrayendo índices...\n";
    
    $sql_indexes = "-- =========================================================================\n";
    $sql_indexes .= "-- ÍNDICES\n";
    $sql_indexes .= "-- =========================================================================\n\n";
    
    $query_indexes = "
        SELECT 
            schemaname,
            tablename,
            indexname,
            indexdef
        FROM pg_indexes
        WHERE schemaname = 'public'
        AND indexname NOT LIKE '%_pkey'
        ORDER BY tablename, indexname;
    ";
    
    $stmt = $conn->query($query_indexes);
    $indexes = $stmt->fetchAll();
    
    foreach ($indexes as $idx) {
        $sql_indexes .= $idx['indexdef'] . ";\n";
    }
    
    echo "   ✅ " . count($indexes) . " índices encontrados\n\n";
    
    // =========================================================================
    // PASO 5: EXTRAER DATOS DE MUESTRA
    // =========================================================================
    echo "📋 Paso 5/5: Extrayendo datos de muestra...\n";
    
    $sql_data = "-- =========================================================================\n";
    $sql_data .= "-- DATOS DE MUESTRA\n";
    $sql_data .= "-- =========================================================================\n\n";
    
    // Tablas prioritarias con orden de dependencias
    $priority_tables = [
        'usuarios',
        'categorias_habilidades', 
        'habilidades',
        'intercambios',
        'conversaciones',
        'participantes_conversacion',
        'mensajes',
        'valoraciones',
        'notificaciones'
    ];
    
    foreach ($priority_tables as $table) {
        if (!in_array($table, $tables)) continue;
        
        $stmt = $conn->query("SELECT * FROM {$table} LIMIT 10");
        $rows = $stmt->fetchAll();
        
        if (empty($rows)) continue;
        
        $sql_data .= "-- Datos de: {$table}\n";
        
        foreach ($rows as $row) {
            $columns = array_keys($row);
            $values = array_map(function($val) use ($conn) {
                if ($val === null) return 'NULL';
                if (is_bool($val)) return $val ? 'TRUE' : 'FALSE';
                if (is_numeric($val)) return $val;
                return $conn->quote($val);
            }, array_values($row));
            
            $sql_data .= "INSERT INTO {$table} (" . implode(', ', $columns) . ")\n";
            $sql_data .= "VALUES (" . implode(', ', $values) . ");\n";
        }
        
        $sql_data .= "\n";
        echo "   ✅ {$table}: " . count($rows) . " registros\n";
    }
    
    // =========================================================================
    // GUARDAR ARCHIVOS
    // =========================================================================
    echo "\n📝 Guardando archivos SQL...\n";
    
    // Script completo de creación
    $schema_complete = "-- =========================================================================\n";
    $schema_complete .= "-- ESQUEMA COMPLETO DE BASE DE DATOS - GaliTroco\n";
    $schema_complete .= "-- Generado automáticamente desde Supabase (Producción)\n";
    $schema_complete .= "-- Fecha: " . date('Y-m-d H:i:s') . "\n";
    $schema_complete .= "-- =========================================================================\n\n";
    $schema_complete .= $sql_enums;
    $schema_complete .= $sql_tables;
    $schema_complete .= $sql_fk;
    $schema_complete .= $sql_indexes;
    
    file_put_contents(__DIR__ . '/schema_production.sql', $schema_complete);
    echo "   ✅ schema_production.sql creado\n";
    
    // Script de datos
    file_put_contents(__DIR__ . '/seeds_production.sql', $sql_data);
    echo "   ✅ seeds_production.sql creado\n";
    
    // Script de instalación completa (esquema + datos)
    $install_complete = $schema_complete . "\n" . $sql_data;
    file_put_contents(__DIR__ . '/install_complete.sql', $install_complete);
    echo "   ✅ install_complete.sql creado (esquema + datos)\n";
    
    echo "\n=============================================================\n";
    echo "✅ EXTRACCIÓN COMPLETADA EXITOSAMENTE\n";
    echo "=============================================================\n";
    echo "\nArchivos generados en: database/\n";
    echo "  - schema_production.sql (solo estructura)\n";
    echo "  - seeds_production.sql (solo datos)\n";
    echo "  - install_complete.sql (estructura + datos)\n\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
