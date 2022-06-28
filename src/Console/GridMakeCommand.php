<?php

namespace Laka\Core\Console;

class GridMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-grid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new validator for the specified module.';

    /**
     * @var string
     */
    protected $className = 'Grid';

    /**
     * @var string
     */
    protected $generatorName = 'grids';

    protected function getParameters($module)
    {
        $params = parent::getParameters($module);
        return array_merge($params, [
            'NAME' => $this->getArgumentName()
        ]);
    }

    /**
     * Get the stub file name based on the plain option
     * @return string
     */
    protected function getStubName()
    {
        return '/grids/grid.stub';
    }
}
