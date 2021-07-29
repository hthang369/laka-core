<?php

namespace Laka\Core\Components\Forms;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class Input extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'form-input';

    public $type;
    public $name;
    public $icon;
    public $prepent;
    public $class;
    public $help;
    public $groupClass;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $type = 'text',
        string $name = '',
        $icon = null,
        bool $prepent = false,
        string $class = '',
        $help = '',
        $groupClass = '',
        $size = null,
        $value = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->class = Classes::get([$class, !$size ?: sprintf('form-control-%s', $size)]);
        $this->prepent = $prepent;
        $this->icon = $icon;
        $this->help = $help;
        $this->groupClass = $groupClass;
        $this->value = $value;
    }
}
