<?php

namespace Laka\Core\Components\Forms;

use Laka\Core\Components\Component;

class Radio extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'form-radio';

    public $name;
    public $label;
    public $chkGroupCLass;
    public $class;
    public $labelAttr;
    public $value;
    public $checked;
    public $showError;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $custom = false, $value = 1, $checked = false, $groupClass = null, $showError = true)
    {
        $this->name = $name;
        $this->label = $label;
        $chkGroupClass = $custom ? ['custom-control', 'custom-radio'] : ['form-check'];
        array_push($chkGroupClass, $groupClass);
        $this->chkGroupCLass = join(' ', $chkGroupClass);
        $this->class = $custom ? ['custom-control-input'] : ['form-check-input'];
        $this->labelAttr = ['class' => $custom ? 'custom-control-label' : 'form-check-label'];
        $this->value = $value;
        $this->checked = $checked;
        $this->showError = $showError;
    }
}
