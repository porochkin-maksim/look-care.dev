<?php

namespace App\Models;

use App\Models\Interfaces\WithId;
use App\Models\Interfaces\ModelInterface;
use App\Models\Permissions\HasPermissionsTrait;
use App\Models\Permissions\RoleAndPermissionInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $emailVerifiedAt
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 * @method static User find($id)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 */
class User extends Authenticatable implements ModelInterface, WithId, RoleAndPermissionInterface, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, VerifiesEmails;
    use HasPermissionsTrait;

    const ADMIN_NAME     = 'admin';
    const ADMIN_PASSWORD = 'admin';

    const TABLE = 'users';

    const COL_NAME              = 'name';
    const COL_EMAIL             = 'email';
    const COL_PASSWORD          = 'password';
    const COL_REMEMBER_TOKEN    = 'remember_token';
    const COL_EMAIL_VERIFIED_AT = 'email_verified_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::COL_NAME,
        self::COL_EMAIL,
        self::COL_PASSWORD,
    ];

    protected $hidden = [
        self::COL_PASSWORD,
        self::COL_REMEMBER_TOKEN,
    ];

    protected $casts = [
        self::COL_EMAIL_VERIFIED_AT => self::CAST_DATETIME,
    ];


}
