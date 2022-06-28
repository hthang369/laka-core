<?php
namespace Laka\Core\Generators;

use Nwidart\Modules\Generators\ModuleGenerator as BaseModuleGenerator;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Laka\Core\Traits\Common\ReflectiorTrait;

class ModuleGenerator extends BaseModuleGenerator
{
    use ReflectiorTrait;

    protected $checkExists = true;

    protected $moduleName;
    protected $subFolder;

    /**
     * Generate the module.
     */
    public function generate() : int
    {
        if ($this->checkExists) {
            return parent::generate();
        }

        $this->generateResources();

        return 0;
    }

    public function delete()
    {
        foreach (['controller', 'repository', 'validator', 'model', 'responses', 'grids', 'forms'] as $name) {
            $this->callDeleteFile($name);
        }

        return 0;
    }

    /**
     * Generate some resources.
     */
    public function generateResources()
    {
        $name = $this->getName();

        if ($this->checkExists) {
            $this->callConsole('module:make-seed', [
                'name' => $name,
                'module' => $this->moduleName,
                '--master' => true
            ], 'seeder');

            $this->callConsole(['module:make-provider', 'module:route-provider'], [
                [
                    'name' => $name . 'ServiceProvider',
                    'module' => $this->moduleName,
                    '--master' => true
                ],
                [
                    'module' => $this->moduleName
                ]
            ], 'provider');
        }

        $this->callConsole('module:make-core-controller', [
            'name' => $name,
            'module' => $this->moduleName,
            'path' => $this->subFolder
        ], 'controller');

        $this->callConsole('module:make-repository', [
            'name' => $name,
            'module' => $this->moduleName,
            'path' => $this->subFolder
        ], 'repository');

        $this->callConsole('module:make-validator', [
            'name' => $name,
            'module' => $this->moduleName,
            'path' => $this->subFolder
        ], 'validator');

        $this->callConsole('module:make-entity', [
            'name' => $name,
            'module' => $this->moduleName,
            'path' => $this->subFolder
        ], 'model');

        $this->callConsole('module:make-response', [
            'name' => $name,
            'module' => $this->moduleName,
            'path' => $this->subFolder
        ], 'responses');

        $this->callConsole('module:make-grid', [
            'name' => $name,
            'module' => $this->moduleName,
            'path' => $this->subFolder
        ], 'grids');

        $this->callConsole('module:make-form', [
            'name' => $name,
            'module' => $this->moduleName,
            'path' => $this->subFolder
        ], 'forms');
    }

    private function callConsole($consoleNames, $options, $name = null)
    {
        $isCheck = is_null($name) ? true : GenerateConfigReader::read($name)->generate();

        if ($isCheck) {
            if (is_string($consoleNames)) {
                $consoleNames = [$consoleNames];
                $options = [$options];
            }
            foreach($consoleNames as $idx => $consoleName) {
                $this->console->call($consoleName, $options[$idx]);
            }
        }
    }

    private function callDeleteFile($name)
    {
        $configReader = GenerateConfigReader::read($name);
        if ($configReader->generate()) {
            $filePath = $configReader->getPath().DIRECTORY_SEPARATOR.$this->subFolder;
            $modulePath = $this->module->getModulePath($this->moduleName);
            $allFiles = $this->module->getFiles()->allFiles($modulePath.DIRECTORY_SEPARATOR.$filePath);
            foreach ($allFiles as $file) {
                if (preg_match("/{$this->name}/", $file->getFilename())) {
                    $this->module->getFiles()->delete($file->getPathname());
                }
            }
        }
    }

    public function setCheckExists($isCheckExists)
    {
        $this->checkExists = $isCheckExists;

        return $this;
    }

    public function setModuleName($name)
    {
        $this->moduleName = $name;

        return $this;
    }

    public function setSubFolder($path)
    {
        $this->subFolder = $path;

        return $this;
    }
}
