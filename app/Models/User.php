<?php

namespace App\Models;

use App\Models\Interfaces\WithId;
use App\Models\Interfaces\ModelInterface;
use App\Models\Permissions\HasPermissionsTrait;
use App\Models\Permissions\RoleAndPermissionInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permissions\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
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
