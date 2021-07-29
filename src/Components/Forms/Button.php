<?php

namespace Laka\Core\Components\Forms;

use Laka\Core\Components\Component;

class Button extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'form-button';

    public $label;
    public $type;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $type = 'button', $variant = 'primary', $size = null)
    {
        $this->label = $label;
        $this->type = $type;
        $btnSize = !is_null($size) ? "btn-{$size}" : '';
        $this->class = ['btn', "btn-{$variant}", $btnSize];
    }
}
