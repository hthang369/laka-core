<?php
namespace Laka\Core\Forms\Fields;

class CheckableType extends FormField
{
    protected function getTemplate()
    {
        return 'checkable';
    }

    protected function getAttributes(array $options = [])
    {
        data_set($this->options, 'attr.class', ['custom-control-input']);
        data_set($options, 'attr.label', [
            'text' => '',
            'attr' => ['class' => 'custom-control-label'],
            'for' => $this->name
        ]);
        data_set($options, 'attr.id', $this->name);
        return $options;
    }
}
