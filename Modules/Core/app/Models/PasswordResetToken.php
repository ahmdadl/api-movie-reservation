<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    protected $updated_at = false;

    #[Scope]
    public function email(Builder $query, string $email): void
    {
        $query->where('email', $email);
    }

    /**
     * create token
     */
    public static function createToken(
        string $email,
        string|int|null $token = null,
    ): self {
        $token = $token ?? random_int(1000, 9999);
        $hashed = hash('sha256', (string) $token . $email);

        return self::updateOrCreate(
            ['email' => $email],
            ['token' => $hashed, 'created_at' => now()],
        );
    }

    /**
     * verify token
     */
    public static function verifyToken(string $email, string|int $token): bool
    {
        return hash('sha256', $token . $email) ===
            self::query()->email($email)->value('token');
    }
}
