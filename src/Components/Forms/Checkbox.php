<?php

namespace Laka\Core\Components\Forms;

use Laka\Core\Components\Component;

class Checkbox extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'form-checkbox';

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
    public function __construct($name, $label, $custom = false, $checked = false, $value = 1, $groupClass = null, $showError = true)
    {
        $this->name = $name;
        $this->label = $label;
        $chkGroupClass = $custom ? ['custom-control', 'custom-checkbox'] : ['form-check'];
        array_push($chkGroupClass, $groupClass);
        $this->chkGroupCLass = join(' ', $chkGroupClass);
        $chkClass = $custom ? ['custom-control-input'] : ['form-check-input'];
        $this->class = $chkClass;
        $this->labelAttr = ['class' => $custom ? 'custom-control-label' : 'form-check-label'];
        $this->value = $value;
        $this->checked = $checked;
        $this->showError = $showError;
    }
}
