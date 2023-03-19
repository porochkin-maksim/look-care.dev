<?php

namespace App\Console\Commands\Users;

use App\Console\BaseCommandClass;
use App\Models\User;
use Database\Seeders\AdminSeeder;

class CreateAdminUser extends BaseCommandClass
{
    const SIGNATURE         = 'create-admin';
    const SIGNATURE_OPTIONS = '{--' . self::OPT_NAME . '=' . User::ADMIN_NAME . '} {--' . self::OPT_PASSWORD . '}';
    const DESCRIPTION       = 'Создание учётной записи администратора';

    protected $signature = self::SIGNATURE . ' ' . self::SIGNATURE_OPTIONS;
    protected $description = self::DESCRIPTION;

    const OPT_NAME = 'name';
    const OPT_PASSWORD = 'password';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $adminName = $this->option(self::OPT_NAME) ?: User::ADMIN_NAME;
        $adminPassword = null;
        $needPassword = $this->option(self::OPT_PASSWORD);

        $this->warn('Создание учётной записи администратора "' . $adminName . '":');

        if ($needPassword) {
            do {
                $adminPassword = $this->secret('Установите пароль пользователя');
            } while (!$adminPassword);
        }

        (new AdminSeeder())->run($adminName, $adminPassword);

        $this->info('Учётная запись ' . (($remake ?? 'y') === 'y' ? 'создана' : 'обновлена') . '.');
    }
}
