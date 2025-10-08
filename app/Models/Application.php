<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Application extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'subdomain',
        'url',
        'icon',
        'color',
        'description',
        'sort_order',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    /**
     * Users who have access to this application
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_applications')
            ->withPivot(['is_active', 'last_accessed_at'])
            ->withTimestamps();
    }

    /**
     * Active users with access to this application
     */
    public function activeUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('is_active', true);
    }

    /**
     * Roles specific to this application
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    /**
     * Permissions specific to this application
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * Scope for active applications
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered applications
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Check if multi-app feature is enabled
     */
    public static function isEnabled(): bool
    {
        return config('app.multi_app_enabled', false);
    }
}
