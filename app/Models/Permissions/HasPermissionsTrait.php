<?php
/*
 * https://www.codecheef.org/article/user-roles-and-permissions-tutorial-in-laravel-without-packages
 */

namespace App\Models\Permissions;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property User $this
 * @property Role[]|Collection $roles
 */
trait HasPermissionsTrait
{
    /**
     * @param string|int|Permission $permission
     * @throws Exception
     */
    public function hasPermissionTo(mixed $permission): bool
    {
        switch (true) {
            case is_numeric($permission):
                $permission = Permission::find($permission);
                break;
            case is_string($permission):
                $permission = Permission::whereCode($permission)->first();
                break;
            case $permission instanceof Permission:
                break;
            default:
                throw new Exception('Undefined type of permission');
        }

        return $this->hasPermissionThroughRole($permission);
    }

    private function hasPermissionThroughRole(Permission $permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains($permission)) {
                return true;
            }
        }
        return false;
    }

    /** @param int[]|Role[] $roles ids */
    public function refreshRoles(array $roles): static
    {
        $this->roles()->detach();
        $this->roles()->sync($roles);
        return $this;
    }

    /** @param string|int|Role ...$roles code|id|object */
    public function hasRole(mixed ...$roles): bool
    {
        foreach ($roles as $role) {
            if (is_array($role)) {
                foreach ($role as $code) {
                    if ($this->roles->contains(Permission::COL_CODE, $code)) {
                        return true;
                    }
                }
            } else {
                if ($this->roles->contains(Permission::COL_CODE, $role->code ?? $role)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            RoleAndPermissionInterface::TABLE_USERS_TO_ROLES,
            self::COL_USER_ID,
            self::COL_ROLE_ID
        );
    }
}
