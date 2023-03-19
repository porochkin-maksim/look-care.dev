<?php

namespace App\Console\Commands;

use App\Console\BaseCommandClass;
use App\Console\Commands\Users\CreateAdminUser;
use App\Helpers\Storage;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RolesSeeder;

class Install extends BaseCommandClass
{
    const SIGNATURE   = 'install';
    const DESCRIPTION = 'Первоначальная настройка проекта';

    protected $signature   = self::SIGNATURE;
    protected $description = self::DESCRIPTION;

    public function handle()
    {
        if (config('app.env') === 'production') {
            $this->abort('Приложение работает в боевом режиме.');
        }

        Storage::clear(storage_path('app\public'));
        Storage::clear(storage_path('logs'));

        $this->warn('Первоначальная настройка проекта:');

        $this->call('config:cache');
        $this->newLine();

        $this->warn('Создание таблиц БД:');
        $this->call('migrate:fresh');
        $this->info('Таблицы созданы.');
        $this->newLine();

        $this->warn('Наполнение таблиц начальными данными:');
        (new PermissionSeeder())->run();
        (new RolesSeeder())->run();
        $this->info('Данные загружены.');
        $this->newLine();

        $this->call(CreateAdminUser::SIGNATURE);
        $this->newLine();

        try {
            $this->warn('Создание ссылки на "' . Storage::modifyPathSlashes(storage_path('app/public')) . '" вручную');
            $this->call('storage:link');
            $this->info('Ссылка создана.');
        }catch (\Exception $e) {
            $this->error('Создайте ссылку в каталоге "' . Storage::modifyPathSlashes(public_path()) . '" вручную');
        }

        $this->info('Первоначальная настройка проекта завершена.');
    }
}
