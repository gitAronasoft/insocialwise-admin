<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Starting MySQL to PostgreSQL Import v2...\n\n";

$columnMappings = [
    'activity' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'admin_audit_logs' => [],
    'admin_feature_flags' => [
        'feature_key' => 'name',
        'enabled' => 'is_enabled',
    ],
    'admin_sessions' => [],
    'admin_users' => [
        'is_active' => 'status',
    ],
    'analytics' => [
        'platform_page_Id' => 'social_page_id',
        'analytic_type' => 'metric_type',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'billing_activity_logs' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'billing_notifications' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'demographics' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'inbox_conversations' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'inbox_messages' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'notification_settings' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'posts' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'post_comments' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'social_page' => [
        'social_media_id' => 'page_id',
        'social_media_name' => 'name',
        'social_media_url' => 'username',
        'profile_picture_url' => 'avatar',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'social_users' => [
        'social_userid' => 'platform_user_id',
        'social_name' => 'name',
        'social_email' => 'email',
        'profile_picture_url' => 'avatar',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'subscriptions' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'subscription_plans' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'users' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
    'webhook_events' => [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ],
];

$skipColumns = [
    'admin_feature_flags' => ['feature_name', 'category', 'force_enabled', 'updated_by'],
    'admin_users' => ['is_active'],
    'analytics' => ['platform', 'total_page_followers', 'total_page_impressions', 'total_page_impressions_unique', 
                    'total_page_views', 'page_post_engagements', 'page_actions_post_reactions_like_total', 'week_date'],
];

$booleanColumns = [
    'admin_users' => ['status'],
    'admin_feature_flags' => ['is_enabled'],
    'admin_sessions' => ['is_current'],
    'subscriptions' => ['cancel_at_period_end'],
    'subscription_plans' => ['is_active', 'is_popular', 'is_recommended'],
    'notification_settings' => ['email_enabled', 'push_enabled', 'in_app_enabled', 'sms_enabled'],
];

$content = file_get_contents(__DIR__ . '/mysql_import.sql');
preg_match_all('/INSERT INTO `([^`]+)` \(([^)]+)\) VALUES\s*([^;]+);/s', $content, $matches, PREG_SET_ORDER);

echo "Found " . count($matches) . " INSERT statements\n\n";
$stats = [];

foreach ($matches as $match) {
    $tableName = $match[1];
    $columnsStr = str_replace('`', '', $match[2]);
    $mysqlColumns = array_map('trim', explode(',', $columnsStr));
    $valuesStr = $match[3];
    
    $values = parseValues($valuesStr);
    if (empty($values)) continue;
    
    $pgCols = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = '$tableName'");
    if (empty($pgCols)) {
        echo "Skipping: $tableName (table doesn't exist)\n";
        continue;
    }
    $pgColumnNames = array_map(fn($c) => $c->column_name, $pgCols);
    
    echo "Importing: $tableName (" . count($values) . " records)... ";
    
    $mapping = $columnMappings[$tableName] ?? [];
    $skip = $skipColumns[$tableName] ?? [];
    $boolCols = $booleanColumns[$tableName] ?? [];
    
    try { DB::statement("DELETE FROM \"$tableName\""); } catch (Exception $e) {}
    
    $success = 0;
    $errors = [];
    
    foreach ($values as $row) {
        if (count($row) !== count($mysqlColumns)) continue;
        
        $data = [];
        foreach ($mysqlColumns as $i => $mysqlCol) {
            if (in_array($mysqlCol, $skip)) continue;
            
            $pgCol = $mapping[$mysqlCol] ?? $mysqlCol;
            
            if (!in_array($pgCol, $pgColumnNames)) continue;
            
            $value = $row[$i];
            
            if ($value === 'NULL' || $value === null) {
                $data[$pgCol] = null;
            } elseif ($value === "'0000-00-00 00:00:00'" || $value === "'0000-00-00'") {
                $data[$pgCol] = null;
            } elseif (in_array($pgCol, $boolCols)) {
                $cleanVal = trim($value, "'");
                $data[$pgCol] = ($cleanVal === '1' || $cleanVal === 'true' || $cleanVal === 'active');
            } else {
                $value = trim($value, "'");
                $value = str_replace("''", "'", $value);
                $value = str_replace("\\'", "'", $value);
                $value = stripslashes($value);
                if ($pgCol === 'status' && $mysqlCol === 'is_active') {
                    $value = ($value === '1') ? 'active' : 'inactive';
                }
                $data[$pgCol] = $value;
            }
        }
        
        if (empty($data)) continue;
        
        try {
            DB::table($tableName)->insert($data);
            $success++;
        } catch (Exception $e) {
            if (count($errors) < 3) {
                $errors[] = substr($e->getMessage(), 0, 150);
            }
        }
    }
    
    echo "$success OK";
    if (!empty($errors)) {
        echo " (errors: " . count($errors) . ")";
    }
    echo "\n";
    
    $stats[$tableName] = $success;
    
    try {
        $maxId = DB::table($tableName)->max('id');
        if ($maxId) {
            DB::statement("SELECT setval(pg_get_serial_sequence('\"$tableName\"', 'id'), $maxId, true)");
        }
    } catch (Exception $e) {}
}

echo "\n=== Import Complete ===\n";
$total = array_sum($stats);
echo "Total records imported: $total\n\n";
foreach ($stats as $table => $count) {
    if ($count > 0) echo "  $table: $count\n";
}

function parseValues($valuesStr) {
    $values = [];
    $current = [];
    $inString = false;
    $escape = false;
    $buffer = '';
    $depth = 0;
    
    for ($i = 0; $i < strlen($valuesStr); $i++) {
        $char = $valuesStr[$i];
        
        if ($escape) {
            $buffer .= $char;
            $escape = false;
            continue;
        }
        
        if ($char === '\\') {
            $escape = true;
            $buffer .= $char;
            continue;
        }
        
        if ($char === "'" && !$escape) {
            $inString = !$inString;
            $buffer .= $char;
            continue;
        }
        
        if (!$inString) {
            if ($char === '(') {
                $depth++;
                if ($depth === 1) {
                    $buffer = '';
                    continue;
                }
            } elseif ($char === ')') {
                $depth--;
                if ($depth === 0) {
                    if (!empty(trim($buffer))) $current[] = trim($buffer);
                    if (!empty($current)) $values[] = $current;
                    $current = [];
                    $buffer = '';
                    continue;
                }
            } elseif ($char === ',' && $depth === 1) {
                $current[] = trim($buffer);
                $buffer = '';
                continue;
            }
        }
        $buffer .= $char;
    }
    return $values;
}
