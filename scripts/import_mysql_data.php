<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$sqlFile = __DIR__ . '/../attached_assets/u742355347_insocial_newdb_(2)_1765353113658.sql';

if (!file_exists($sqlFile)) {
    echo "SQL file not found: $sqlFile\n";
    exit(1);
}

$content = file_get_contents($sqlFile);

$inserts = [];
preg_match_all('/INSERT INTO `([^`]+)` \(([^)]+)\) VALUES\s*(.*?);/s', $content, $matches, PREG_SET_ORDER);

echo "Found " . count($matches) . " INSERT statements\n";

$globalColumnRename = [
    'createdAt' => 'created_at',
    'updatedAt' => 'updated_at',
];

$columnMapping = [
    'admin_users' => [
        'is_active' => 'status',
    ],
    'admin_sessions' => [
        'admin_id' => 'admin_user_id',
    ],
    'users' => [
        'id' => null,
        'firstName' => 'name',
        'lastName' => null,
        'bio' => null,
        'company' => null,
        'jobTitle' => null,
        'userLocation' => null,
        'userWebsite' => null,
        'role' => null,
        'profileImage' => 'profile_photo',
        'timeZone' => 'timezone',
        'otp' => null,
        'otpGeneratedAt' => null,
        'resetPasswordToken' => null,
        'resetPasswordRequestTime' => null,
        'onboardGoal' => null,
        'onboardRole' => null,
        'onboard_status' => null,
        'billing_name' => null,
        'billing_email' => null,
        'billing_phone' => null,
        'billing_address_line1' => null,
        'billing_address_line2' => null,
        'billing_city' => null,
        'billing_state' => null,
        'billing_postal_code' => null,
        'billing_country' => null,
        'tax_id' => null,
        'tax_id_type' => null,
        'default_payment_method_id' => null,
    ],
];

$tablesToSkip = [
    'migrations',
    'admin_audit_logs',
    'sessions',
    'personal_access_tokens',
    'cache',
    'cache_locks',
    'jobs',
    'failed_jobs',
];

function parseValues($valuesStr) {
    $rows = [];
    $depth = 0;
    $currentRow = '';
    $inString = false;
    $escapeNext = false;
    
    for ($i = 0; $i < strlen($valuesStr); $i++) {
        $char = $valuesStr[$i];
        
        if ($escapeNext) {
            $currentRow .= $char;
            $escapeNext = false;
            continue;
        }
        
        if ($char === '\\') {
            $currentRow .= $char;
            $escapeNext = true;
            continue;
        }
        
        if ($char === "'" && !$escapeNext) {
            $inString = !$inString;
            $currentRow .= $char;
            continue;
        }
        
        if (!$inString) {
            if ($char === '(') {
                $depth++;
                if ($depth === 1) {
                    $currentRow = '';
                    continue;
                }
            } elseif ($char === ')') {
                $depth--;
                if ($depth === 0) {
                    $rows[] = $currentRow;
                    $currentRow = '';
                    continue;
                }
            }
        }
        
        if ($depth > 0) {
            $currentRow .= $char;
        }
    }
    
    return $rows;
}

function convertValue($value) {
    $value = trim($value);
    
    if ($value === 'NULL') {
        return null;
    }
    
    if (preg_match("/^'(.*)'$/s", $value, $m)) {
        $str = $m[1];
        $str = str_replace("\\'", "'", $str);
        $str = str_replace("\\\\", "\\", $str);
        
        if ($str === '0000-00-00 00:00:00' || $str === '0000-00-00') {
            return null;
        }
        
        return $str;
    }
    
    if (is_numeric($value)) {
        if (strpos($value, '.') !== false) {
            return floatval($value);
        }
        return intval($value);
    }
    
    return $value;
}

function parseRowValues($rowStr) {
    $values = [];
    $current = '';
    $inString = false;
    $escapeNext = false;
    $depth = 0;
    
    for ($i = 0; $i < strlen($rowStr); $i++) {
        $char = $rowStr[$i];
        
        if ($escapeNext) {
            $current .= $char;
            $escapeNext = false;
            continue;
        }
        
        if ($char === '\\') {
            $current .= $char;
            $escapeNext = true;
            continue;
        }
        
        if ($char === "'" && !$escapeNext) {
            $inString = !$inString;
            $current .= $char;
            continue;
        }
        
        if (!$inString) {
            if ($char === '(' || $char === '{' || $char === '[') {
                $depth++;
            } elseif ($char === ')' || $char === '}' || $char === ']') {
                $depth--;
            }
            
            if ($char === ',' && $depth === 0) {
                $values[] = convertValue($current);
                $current = '';
                continue;
            }
        }
        
        $current .= $char;
    }
    
    if ($current !== '') {
        $values[] = convertValue($current);
    }
    
    return $values;
}

foreach ($matches as $match) {
    $mysqlTable = $match[1];
    $columnsStr = $match[2];
    $valuesStr = $match[3];
    
    if (in_array($mysqlTable, $tablesToSkip)) {
        echo "Skipping table: $mysqlTable\n";
        continue;
    }
    
    $pgTable = $mysqlTable;
    
    $columns = array_map(function($col) {
        return trim(str_replace('`', '', $col));
    }, explode(',', $columnsStr));
    
    $newColumns = [];
    foreach ($columns as $col) {
        if (isset($globalColumnRename[$col])) {
            $col = $globalColumnRename[$col];
        }
        
        if (isset($columnMapping[$mysqlTable][$col])) {
            $mapped = $columnMapping[$mysqlTable][$col];
            if ($mapped === null) {
                $newColumns[] = null;
            } else {
                $newColumns[] = $mapped;
            }
        } else {
            $newColumns[] = $col;
        }
    }
    
    $rows = parseValues($valuesStr);
    
    echo "Processing $mysqlTable -> $pgTable (" . count($rows) . " rows)\n";
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($rows as $rowStr) {
        $values = parseRowValues($rowStr);
        
        if (count($values) !== count($newColumns)) {
            echo "  Warning: Column count mismatch for $pgTable\n";
            $errorCount++;
            continue;
        }
        
        $data = [];
        for ($i = 0; $i < count($newColumns); $i++) {
            if ($newColumns[$i] !== null) {
                $data[$newColumns[$i]] = $values[$i];
            }
        }
        
        if ($pgTable === 'users') {
            if (isset($data['name']) && isset($values[array_search('lastName', $columns)])) {
                $lastNameIdx = array_search('lastName', $columns);
                if ($lastNameIdx !== false && !empty($values[$lastNameIdx])) {
                    $data['name'] = $data['name'] . ' ' . $values[$lastNameIdx];
                }
            }
        }
        
        if ($pgTable === 'admin_users' && isset($data['status'])) {
            $data['status'] = $data['status'] == 1 ? 'active' : 'inactive';
        }
        
        $booleanColumns = [
            'admin_feature_flags' => ['enabled', 'force_enabled'],
            'admin_sessions' => ['is_current'],
            'notification_settings' => ['enabled', 'retry_enabled', 'user_configurable'],
            'inbox_messages' => ['is_read'],
            'webhook_events' => ['livemode', 'signature_verified'],
            'subscriptions' => ['auto_renew', 'cancel_at_period_end'],
        ];
        
        if (isset($booleanColumns[$pgTable])) {
            foreach ($booleanColumns[$pgTable] as $boolCol) {
                if (isset($data[$boolCol])) {
                    $data[$boolCol] = (bool)$data[$boolCol];
                }
            }
        }
        
        try {
            DB::table($pgTable)->insert($data);
            $successCount++;
        } catch (\Exception $e) {
            $errorCount++;
            if ($errorCount <= 3) {
                echo "  Error inserting into $pgTable: " . substr($e->getMessage(), 0, 200) . "\n";
            }
        }
    }
    
    echo "  Inserted: $successCount, Errors: $errorCount\n";
    
    try {
        $maxId = DB::table($pgTable)->max('id');
        if ($maxId) {
            DB::statement("SELECT setval(pg_get_serial_sequence('$pgTable', 'id'), $maxId)");
        }
    } catch (\Exception $e) {
    }
}

echo "\n--- Seeding roles and permissions ---\n";

try {
    $superAdminRole = DB::table('roles')->insertGetId([
        'name' => 'super-admin',
        'guard_name' => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Created super-admin role (ID: $superAdminRole)\n";
    
    $adminRole = DB::table('roles')->insertGetId([
        'name' => 'admin',
        'guard_name' => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Created admin role (ID: $adminRole)\n";
    
    $adminUser = DB::table('admin_users')->where('email', 'admin@insocialwise.com')->first();
    if ($adminUser) {
        DB::table('admin_user_role')->insert([
            'admin_user_id' => $adminUser->id,
            'role_id' => $superAdminRole,
        ]);
        echo "Assigned super-admin role to admin user\n";
    }
} catch (\Exception $e) {
    echo "Roles already exist or error: " . $e->getMessage() . "\n";
}

echo "\nData import completed!\n";
