<?php

namespace App\Models\Permissions;

use App\Models\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Permissions\Role
 *
 * @property int $id
 * @property string $name Название роли
 * @property string $code Уникальный код
 * @property int|null $sort Порядок для отображения
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permissions\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereSort($value)
 * @mixin \Eloquent
 */
class Role extends Model implements ModelInterface, RoleAndPermissionInterface
{
    const ADMIN = 'admin';

    const TABLE = 'roles';

    const COL_NAME = 'name';
    const COL_CODE = 'code';
    const COL_SORT = 'sort';

    protected $table    = self::TABLE;
    protected $fillable = [
        self::COL_NAME,
        self::COL_CODE,
        self::COL_SORT,
    ];

    public $timestamps = false;

    protected $with = [
        'permissions',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            self::TABLE_ROLES_TO_PERMISSIONS,
            self::COL_ROLE_ID,
            self::COL_PERMISSION_ID);
    }
}
