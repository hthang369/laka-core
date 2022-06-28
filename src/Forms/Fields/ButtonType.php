<?php
namespace Laka\Core\Forms\Fields;

class ButtonType extends FormField
{
    protected function getTemplate()
    {
        return 'button';
    }

    protected function getAttributes(array $options = [])
    {
        $attrClass = $this->getOption('attr.class');
        $variant = array_pull($options, 'variant');
        $size = array_pull($options, 'size');
        $attrClass = array_merge($attrClass, [
            'btn-'.($variant ?? 'secondary'),
            "btn-{$size}" => !blank($size)
        ]);
        data_set($options, 'attr.class', $attrClass);

        return $options;
    }

    /**
     * Default options for field.
     *
     * @return array
     */
    protected function getDefaults()
    {
        return ['attr' => ['class' => ['btn']]];
    }

    protected function setupLabel()
    {
        parent::setupLabel();
        $label = $this->getOption('label');
        $icon = array_pull($this->options, 'icon');
        $label = sprintf('<i class="fa %s"></i><span class="ml-1">%s</span>', $icon, $label);
        $this->setOption('label', $label);
    }
}
