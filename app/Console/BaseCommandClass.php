<?php


namespace App\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class BaseCommandClass extends Command
{
    const SIGNATURE         = '';
    const SIGNATURE_OPTIONS = '';
    const DESCRIPTION       = '';

    protected $signature = self::SIGNATURE . ' ' . self::SIGNATURE_OPTIONS;
    protected $description = self::DESCRIPTION;

    protected $console;

    public function __construct()
    {
        $this->console = new ConsoleOutput();
        parent::__construct();
    }

    public abstract function handle();

    public function abort(string $text = '')
    {
        $this->error($text ?: 'Приложение остановлено');
        die();
    }
}
