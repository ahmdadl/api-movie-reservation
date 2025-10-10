<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Database\Factories\UserFactory;
use Modules\Users\Enums\UserRole;

#[UseFactory(UserFactory::class)]
class User extends Model
{
    use HasFactory, HasUuids;

    /**
     * casts
     */
    public function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }
}
