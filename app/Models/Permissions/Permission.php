<?php

namespace App\Models\Permissions;

use App\Models\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $code
 * @property int $sort
 * @method static Permission find($id)
 * @method static Builder|Permission whereCode($value)
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
