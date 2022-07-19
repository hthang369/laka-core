<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

/**
 * Use Bootstrap <x-button> component for actions in forms, dialogs, and more. Includes support for a handful of contextual variations, sizes, states, and more
 */
class Button extends Component
{
    public $text;
    public $btnType;
    public $attrs;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'button';

    /**
     * @param string $variant
     * @param string $type
     * @param string $text
     * @param string $size
     * @param string $icon
     * @param bool $block
     * @param bool $pill
     * @param bool $squared
     * @param bool $disabled
     */
    public function __construct(
        $variant = 'secondary',
        $type = 'button',
        $text = '',
        $size = '',
        $icon = '',
        $block = false,
        $pill = false,
        $squared = false,
        $disabled = false
    )
    {
        $this->text = $text ?? '';
        $this->btnType = $this->type = $type ?? 'button';
        $this->variant = $variant ?? '';
        if (!blank($icon)) {
            $iconClass = !empty($text) ? 'mr-2' : '';
            $this->text = '<i class="'.array_css_class([$icon, $iconClass]).'"></i>'.$this->text;
            $this->btnType = 'button';
        }
        $this->attrs = [
            'class' => array_css_class([
                'btn',
                "btn-{$variant}" => !blank($variant),
                "btn-{$size}" => !blank($size),
                'btn-block' => $block,
                'rounded-pill' => $pill,
                'rounded-0' => $squared,
            ]),
            'disabled' => $disabled,
            'type' => $type
        ];
    }
}
