<?php

namespace Laka\Core\Components\Forms;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class Select extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'form-select';

    public $name;
    public $class;
    public $help;
    public $groupClass;
    public $selected;
    public $items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $items,
        string $name = '',
        string $class = '',
        $help = '',
        $groupClass = '',
        $selected = null,
        $size = null,
        $custom = false)
    {
        $this->items = $items;
        $this->name = $name;
        $controlClass = sprintf('%s-control', $custom ? 'custom' : 'form');
        $this->class = Classes::get([
            $controlClass,
            $class,
            !$size ?: sprintf('%s-%s', $controlClass, $size)
        ]);
        $this->help = $help;
        $this->groupClass = $groupClass;
        $this->selected = $selected;
    }
}
