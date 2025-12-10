# Database Schema Synchronization Guide

This guide ensures migrations, seeders, models, and code stay in sync when making database changes.

## 3-Layer Synchronization Process

### Layer 1: Database Schema (Migrations)
**Location**: `database/migrations/`

When adding new tables or columns:
1. Create migration with `php artisan make:migration`
2. Define schema in the migration file
3. **Document exact column names** (these are the source of truth)

**Example - Admin Audit Logs Table**:
```php
Schema::create('admin_audit_logs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('admin_user_id')->nullable();
    $table->string('action');
    $table->string('model_type')->nullable();
    $table->unsignedBigInteger('model_id')->nullable();
    $table->json('old_values')->nullable();
    $table->json('new_values')->nullable();
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->text('description')->nullable();
    $table->timestamps();
});
```

### Layer 2: Eloquent Models
**Location**: `app/Models/`

Models MUST match the migration schema exactly:

**Fillable Array** - List ONLY columns from the migration:
```php
protected $fillable = [
    'admin_user_id',      // Matches migration
    'action',             // Matches migration
    'model_type',         // Matches migration
    'model_id',           // Matches migration
    'description',        // Matches migration
    'old_values',         // Matches migration
    'new_values',         // Matches migration
    'ip_address',         // Matches migration
    'user_agent',         // Matches migration
];

// DO NOT include columns that don't exist in migration:
// ❌ 'admin_id' (migration uses admin_user_id)
// ❌ 'action_type' (migration uses action)
// ❌ 'entity_type' (migration uses model_type)
```

**Relationships** - Use correct foreign key column name:
```php
public function admin(): BelongsTo
{
    return $this->belongsTo(AdminUser::class, 'admin_user_id');
    //                                          ↑ matches migration
}
```

**Casts** - Only cast columns that exist:
```php
protected function casts(): array
{
    return [
        'old_values' => 'array',    // Column exists
        'new_values' => 'array',    // Column exists
        // ❌ Don't cast non-existent columns
    ];
}
```

### Layer 3: Services & Controllers
**Location**: `app/Services/`, `app/Http/Controllers/`

All database operations MUST use correct column names:

**In Services**:
```php
// ✅ CORRECT - Matches migration & model
AdminAuditLog::create([
    'admin_user_id' => $admin->id,
    'action' => 'login',
    'model_type' => 'User',
    'model_id' => $userId,
]);

// ❌ WRONG - Column names don't match migration
AdminAuditLog::create([
    'admin_id' => $admin->id,           // ← Column is admin_user_id
    'action_type' => 'login',           // ← Column is action
    'entity_type' => 'User',            // ← Column is model_type
]);
```

**In Queries**:
```php
// ✅ CORRECT
AdminAuditLog::where('admin_user_id', $adminId)->get();
AdminAuditLog::where('action', 'login')->get();

// ❌ WRONG
AdminAuditLog::where('admin_id', $adminId)->get();
AdminAuditLog::where('action_type', 'login')->get();
```

## Verification Checklist

Before deploying or running migrations, verify:

### 1. Migration File
- [ ] Column names are explicit and clear
- [ ] Data types match intended use
- [ ] Foreign keys properly defined
- [ ] Indexes added for frequently queried columns

### 2. Model (Fillable & Casts)
```bash
# Extract column names from migration
# Paste into model's fillable array

# MIGRATION: admin_user_id, action, model_type, model_id, ...
# MODEL fillable: Should match exactly
```

### 3. Service/Controller Code
```bash
# Search all services and controllers for column usage
grep -r "admin_audit_logs" app/Services/ app/Http/Controllers/

# Verify each database operation uses correct column names
```

### 4. Quick Test
```bash
# After making changes, test with fresh migration
php artisan migrate:fresh --seed

# This catches any mismatches before production
```

## Common Mistakes to Avoid

| Mistake | Why It Fails | Fix |
|---------|------------|-----|
| Migration uses `admin_user_id`, code uses `admin_id` | Column doesn't exist | Use `admin_user_id` everywhere |
| Model fillable includes non-existent columns | Mass assignment fails silently | Only include migration columns |
| Query uses wrong column name | No results or errors | Match migration exactly |
| Relationship foreign key wrong | Queries fail or return null | Use correct column name |
| Cast a non-existent column | Casting ignored, data incorrect | Only cast migration columns |

## If You Modify a Column

If changing a column (e.g., `admin_id` → `admin_user_id`):

1. **Create a migration** to rename/modify
2. **Update model fillable** to new column name
3. **Search and replace** in all services/controllers
4. **Update relationships** with correct foreign key
5. **Test with fresh migration** before pushing

## Development Workflow

```
1. Write Migration (source of truth)
   ↓
2. Update Model (fillable, relationships, casts)
   ↓
3. Update Services/Controllers (use correct columns)
   ↓
4. Run: php artisan migrate:fresh --seed
   ↓
5. Test all affected features
   ↓
6. Commit all changes together
```

## Current State (December 10, 2025)

**Database Schema**: Migrations are correct ✅
- admin_audit_logs: admin_user_id, action, model_type, model_id, ...
- admin_users: status (not is_active)
- All tables match migrations

**Models**: NOW SYNCHRONIZED ✅
- AdminAuditLog fillable updated to match migration
- AdminUser fillable updated to match migration
- All relationships use correct foreign keys

**Services**: NOW SYNCHRONIZED ✅
- AdminAuditService uses admin_user_id, action, model_type, model_id
- All audit logging methods corrected

**Status**: Fresh migrations will now work perfectly! ✅
