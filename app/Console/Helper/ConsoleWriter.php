<?php


namespace App\Console\Helper;


use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleWriter
{
    private ConsoleOutput $output;
    protected int $verbosity = OutputInterface::VERBOSITY_NORMAL;

    /**
     * The mapping between human readable verbosity levels and Symfony's OutputInterface.
     */
    protected array $verbosityMap = [
        'v'      => OutputInterface::VERBOSITY_VERBOSE,
        'vv'     => OutputInterface::VERBOSITY_VERY_VERBOSE,
        'vvv'    => OutputInterface::VERBOSITY_DEBUG,
        'quiet'  => OutputInterface::VERBOSITY_QUIET,
        'normal' => OutputInterface::VERBOSITY_NORMAL,
    ];

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    public function breakLine(): void
    {
        $this->output->writeln('');
    }

    public function info(string $string, $verbosity = null): void
    {
        $this->line($string, null, $verbosity);
    }

    public function error($string, $verbosity = null): void
    {
        $this->line($string, 'error', $verbosity);
    }

    public function warn(string $string, $verbosity = null): void
    {
        if (! $this->output->getFormatter()->hasStyle('warning')) {
            $style = new OutputFormatterStyle('yellow');

            $this->output->getFormatter()->setStyle('warning', $style);
        }
        $this->line($string, 'warning', $verbosity);
    }

    public function line(string $string, $style = null, $verbosity = null): void
    {
        $styled = '<info>' . $this->getTime() . '</info> ' . ($style ? "<$style>$string</$style>" : $string);
        $this->output->writeln($styled, $this->parseVerbosity($verbosity));
    }

    public function write(string $string, $style = null, $verbosity = null): void
    {
        $styled = '<info>' . $this->getTime() . '</info> ' . ($style ? "<$style>$string</$style>" : $string);
        $this->output->write("\r$styled", false, $this->parseVerbosity($verbosity));
    }

    public function createProgressBar(int $size): ProgressBar
    {
        return new ProgressBar($this->output, $size);
    }

    public function output(): ConsoleOutput
    {
        return $this->output;
    }

    protected function parseVerbosity($level = null)
    {
        if (isset($this->verbosityMap[$level])) {
            $level = $this->verbosityMap[$level];
        } elseif (! is_int($level)) {
            $level = $this->verbosity;
        }

        return $level;
    }

    protected function getTime(): string
    {
        return date('H:i:s', strtotime('now'));
    }

    public function getTimeWithStyle(): string
    {
        return '<info>' . date('H:i:s', strtotime('now')) . '</info>';
    }
}
