<?php

namespace Laka\Core\Database;

use Closure;
use Illuminate\Database\Seeder;

/**
 * Abstract class BaseSeeder
 * @package Laka\Core\Database
 */
abstract class BaseSeeder extends Seeder
{
    protected function commandOutput($message)
    {
        $this->command->getOutput()->writeln($message);
    }

    protected function outputInfo($message)
    {
        $this->commandOutput("<info>{$message}</info>");
    }

    protected function outputComment($message)
    {
        $this->commandOutput("<comment>{$message}</comment>");
    }

    protected function outputError($message)
    {
        $this->commandOutput("<error>{$message}</error>");
    }

    protected function outputWithProgressBar($totalSteps, Closure $callback)
    {
        return $this->command->withProgressBar($totalSteps, $callback);
    }
}
