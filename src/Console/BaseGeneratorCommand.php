<?php

namespace Laka\Core\Console;

use Illuminate\Support\Str;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Stub;
use Nwidart\Modules\Traits\ModuleCommandTrait;

abstract class BaseGeneratorCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * @var string
     */
    protected $className = '';

    /**
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * @var string
     */
    protected $extension = 'php';

    /**
     * Get controller name.
     *
     * @return string
     */
    protected function getDestinationPath()
    {
        return $this->laravel['modules']->getModulePath($this->getModuleName());
    }

    protected function setStubBasePath()
    {
        Stub::setBasePath(str_replace('\\', '/', __DIR__.DIRECTORY_SEPARATOR.'stubs'));
    }

    /**
     * Execute the console command.
     */
    public function handle() : int
    {
        $this->setStubBasePath();
        return parent::handle();
    }

    /**
     * @return array|string
     */
    protected function getArgumentName()
    {
        return Str::studly($this->argument($this->argumentName));
    }

    protected function getClassFileName()
    {
        $name = $this->getArgumentName();

        if (Str::contains(strtolower($name), strtolower($this->className)) === false) {
            $name .= $this->className;
        }

        return $name;
    }

    protected function generateFileName()
    {
        return $this->getClassFileName().'.'.$this->extension;
    }

    protected function generatePathName($path, $subFolder = null)
    {
        return join(DIRECTORY_SEPARATOR, array_filter([$path, $subFolder, $this->generateFileName()]));
    }
}
