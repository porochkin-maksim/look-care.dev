<?php

namespace App\Models\Permissions;

use App\Models\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property string $name
 * @property string $code
 * @property int $sort
 * @property Permission[]|Collection $permissions
 */
class Role extends Model implements ModelInterface, RoleAndPermissionInterface
{
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
