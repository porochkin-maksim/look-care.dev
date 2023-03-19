<?php

namespace App\Models\Permissions;

interface RoleAndPermissionInterface
{
    const TABLE_ROLES_TO_PERMISSIONS = 'role_permissions';
    const TABLE_USERS_TO_ROLES       = 'user_roles';

    const COL_USER_ID       = 'user_id';
    const COL_ROLE_ID       = 'role_id';
    const COL_PERMISSION_ID = 'permission_id';
}
