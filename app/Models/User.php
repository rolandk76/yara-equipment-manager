<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'shared';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'azure_id',
        'employee_id',
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'mobile',
        'department',
        'position',
        'location',
        'manager_id',
        'default_cost_center_id',
        'language',
        'timezone',
        'notification_preferences',
        'is_active',
        'out_of_office_from',
        'out_of_office_until',
        'delegate_user_id',
        'last_login_at',
        'last_login_ip',
        'two_factor_enabled',
        'password_changed_at',
        'metadata',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notification_preferences' => 'array',
            'metadata' => 'array',
            'is_active' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'out_of_office_from' => 'date',
            'out_of_office_until' => 'date',
            'last_login_at' => 'datetime',
            'password_changed_at' => 'datetime',
        ];
    }

    // ==================== Relationships ====================

    /**
     * Get the user's manager
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get users managed by this user
     */
    public function subordinates(): HasMany
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    /**
     * Get the delegate user
     */
    public function delegate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delegate_user_id');
    }

    /**
     * Get users who have this user as delegate
     */
    public function delegatingUsers(): HasMany
    {
        return $this->hasMany(User::class, 'delegate_user_id');
    }

    /**
     * Get the default cost center
     */
    public function defaultCostCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class, 'default_cost_center_id');
    }

    /**
     * Alias for defaultCostCenter (for admin panel)
     */
    public function costCenter(): BelongsTo
    {
        return $this->defaultCostCenter();
    }

    /**
     * Get trips created by this user
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Get trips where this user is the approver
     */
    public function tripsToApprove(): HasMany
    {
        return $this->hasMany(Trip::class, 'approver_id');
    }

    /**
     * Get approvals assigned to this user
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class, 'approver_id');
    }

    /**
     * Get documents uploaded by this user
     */
    public function uploadedDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    // ==================== Scopes ====================

    /**
     * Scope to get only active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get users by department
     */
    public function scopeInDepartment($query, string $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope to get users who are currently out of office
     */
    public function scopeOutOfOffice($query)
    {
        $today = now()->toDateString();
        return $query->whereNotNull('out_of_office_from')
            ->whereNotNull('out_of_office_until')
            ->where('out_of_office_from', '<=', $today)
            ->where('out_of_office_until', '>=', $today);
    }

    // ==================== Helper Methods ====================

    /**
     * Check if user is currently out of office
     */
    public function isOutOfOffice(): bool
    {
        if (!$this->out_of_office_from || !$this->out_of_office_until) {
            return false;
        }

        $today = now();
        return $today->between($this->out_of_office_from, $this->out_of_office_until);
    }

    /**
     * Get the effective approver (delegate if out of office)
     */
    public function getEffectiveApprover(): ?User
    {
        if ($this->isOutOfOffice() && $this->delegate_user_id) {
            return $this->delegate;
        }

        return $this;
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute(): string
    {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name} {$this->last_name}";
        }

        return $this->name;
    }

    // ==================== Multi-App Support ====================

    /**
     * Applications this user has access to
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'user_applications')
            ->withPivot(['is_active', 'last_accessed_at'])
            ->withTimestamps();
    }

    /**
     * Get active applications for this user
     */
    public function activeApplications()
    {
        return $this->applications()
            ->wherePivot('is_active', true)
            ->where('applications.is_active', true)
            ->ordered();
    }

    /**
     * Check if user has access to an application
     */
    public function hasAccessToApplication($applicationSlug): bool
    {
        // If multi-app is disabled, always return true
        if (!Application::isEnabled()) {
            return true;
        }

        return $this->activeApplications()
            ->where('slug', $applicationSlug)
            ->exists();
    }

    /**
     * Get user's role in a specific application
     */
    public function getRoleInApplication($applicationId)
    {
        return $this->roles()
            ->where('application_id', $applicationId)
            ->first();
    }

    /**
     * Assign role in specific application
     */
    public function assignRoleInApplication($roleName, $applicationId)
    {
        $role = \Spatie\Permission\Models\Role::where('name', $roleName)
            ->where('application_id', $applicationId)
            ->firstOrFail();

        return $this->assignRole($role);
    }

    /**
     * Update last accessed time for application
     */
    public function touchApplicationAccess($applicationId)
    {
        $this->applications()->updateExistingPivot($applicationId, [
            'last_accessed_at' => now(),
        ]);
    }
}
