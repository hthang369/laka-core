<?php

namespace Laka\Core\Components\Forms;

use Laka\Core\Components\Component;

class RadioGroup extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'form-radio-group';

    public $name;
    public $items;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $items)
    {
        $this->name = $name;
        $this->items = $items;
        $this->class = ['radio-group'];
    }
}
