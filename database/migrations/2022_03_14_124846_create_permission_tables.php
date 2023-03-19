<?php

use App\Models\Interfaces\WithId;
use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;
use App\Models\User;
use App\Models\Permissions\RoleAndPermissionInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const ROLES_TO_PERMISSIONS = RoleAndPermissionInterface::TABLE_ROLES_TO_PERMISSIONS;
    private const USERS_TO_ROLES       = RoleAndPermissionInterface::TABLE_USERS_TO_ROLES;

    private const ID            = WithId::COL_ID;
    private const PERMISSION_ID = RoleAndPermissionInterface::COL_PERMISSION_ID;
    private const ROLE_ID       = RoleAndPermissionInterface::COL_ROLE_ID;
    private const USER_ID       = RoleAndPermissionInterface::COL_USER_ID;

    public function up(): void
    {
        Schema::create(Role::TABLE, function (Blueprint $table) {
            $table->comment('Роли для группировки разрешений');
            $table->id();
            $table->string(Role::COL_NAME, 100)->comment('Название роли');
            $table->string(Role::COL_CODE, 50)->unique('code')->comment('Уникальный код');
            $table->integer(Role::COL_SORT)->nullable()->comment('Порядок для отображения');
        });

        Schema::create(Permission::TABLE, function (Blueprint $table) {
            $table->comment('Разрешения для разделения доступа к функционалу приложения');
            $table->id();
            $table->string(Permission::COL_NAME, 100)->comment('Название разрешения');
            $table->string(Permission::COL_CODE, 50)->unique('code')->comment('Уникальный код');
            $table->integer(Role::COL_SORT)->nullable()->comment('Порядок для отображения');
        });

        Schema::create(self::ROLES_TO_PERMISSIONS, function (Blueprint $table) {
            $table->comment('Связи ролей с разрешениями');
            $table->foreignId(self::ROLE_ID)->references(self::ID)->on(Role::TABLE)->cascadeOnDelete();
            $table->foreignId(self::PERMISSION_ID)->references(self::ID)->on(Permission::TABLE)->cascadeOnDelete();

            $table->primary([
                self::ROLE_ID,
                self::PERMISSION_ID,
            ]);
        });

        Schema::create(self::USERS_TO_ROLES, function (Blueprint $table) {
            $table->comment('Связи пользователей с ролями');
            $table->foreignId(self::USER_ID)->references(self::ID)->on(User::TABLE)->cascadeOnDelete();
            $table->foreignId(self::ROLE_ID)->references(self::ID)->on(Role::TABLE)->cascadeOnDelete();

            $table->primary([
                self::USER_ID,
                self::ROLE_ID,
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::USERS_TO_ROLES);
        Schema::dropIfExists(self::ROLES_TO_PERMISSIONS);
        Schema::dropIfExists(Permission::TABLE);
        Schema::dropIfExists(Role::TABLE);
    }
};
