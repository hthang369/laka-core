<?php

namespace Laka\Core\Components\Forms;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class Datepicker extends Component
{
    public $name;
    public $class;
    public $dateFormat = 'dd/mm/yyyy';
    public $iconClass;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'datepicker';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $dateFormat = null, $size = null)
    {
        $this->name = $name;
        $this->class = Classes::get([
            'form-control',
            !$size ? '' : sprintf('form-control-%s', $size)
        ]);
    }
}
