<?php

declare(strict_types=1);

namespace Modules\Users\Models;

use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\ValueObjects\UserTotals;
use Modules\Users\Database\Factories\UserFactory;
use Modules\Users\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Modules\Core\Models\Scopes\HasActiveState;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Users\Transformers\UserTransformer;

#[UseFactory(UserFactory::class)]
#[UseResource(UserTransformer::class)]
final class User extends Authenticatable
{
    use HasFactory,
        HasUuids,
        SoftDeletes,
        HasRoles,
        HasActiveState,
        HasApiTokens;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * casts
     */
    public function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'totals' => UserTotals::class,
        ];
    }

    /**
     * Scope a query to only include admin users.
     */
    #[Scope]
    protected function admin(Builder $query): void
    {
        $query->where('role', UserRole::ADMIN);
    }

    /**
     * Scope a query to only include user users.
     */
    #[Scope]
    protected function user(Builder $query): void
    {
        $query->where('role', UserRole::USER);
    }

    /**
     * Scope a query to only include guest users.
     */
    #[Scope]
    protected function guest(Builder $query): void
    {
        $query->where('role', UserRole::GUEST);
    }

    /**
     * who can access admin panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === UserRole::ADMIN;
    }
}
