<?php
namespace Laka\Core\Forms\Fields;

use Laka\Core\Forms\Form;

class CheckableGroupType extends FormField
{
    public function __construct($name, $type, Form $parent, array $options = [])
    {
        parent::__construct($name, $type, $parent, $options);
        $this->type = trim($this->type, '-group');
    }

    protected function getTemplate()
    {
        return 'checkable-group';
    }

    protected function getAttributes(array $options = [])
    {
        $type = trim($this->type, '-group');
        data_set($this->options, 'attr.class', ['custom-control-input']);
        data_set($options, 'attr.label', [
            'text' => '',
            'attr' => ['class' => 'custom-control-label'],
            'for' => $this->name
        ]);
        data_set($options, 'attr.id', $this->name);
        $optCtrlAttr = array_wrap(array_pull($options, 'control'));
        $defaultCtrlAttr = ['class' => ['custom-control', "custom-{$type}"]];
        data_set($options, 'attr.control', array_merge_recursive_simple($defaultCtrlAttr, $optCtrlAttr));

        return $options;
    }
}
