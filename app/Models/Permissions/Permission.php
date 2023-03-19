<?php

namespace App\Models\Permissions;

use App\Models\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Permissions\Permission
 *
 * @property int $id
 * @property string $name Название разрешения
 * @property string $code Уникальный код
 * @property int|null $sort Порядок для отображения
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereSort($value)
 * @mixin \Eloquent
 */
class Permission extends Model implements ModelInterface
{
    /** здесь описываются константы разрешений */
    const ADMIN = 'admin';

    const TABLE = 'permissions';

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
}
