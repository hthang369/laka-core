<?php

namespace Laka\Core\Components\Common;

use Illuminate\Support\Arr;
use Laka\Core\Components\Component;

/**
 * Use Bootstrap <x-button> component for actions in forms, dialogs, and more. Includes support for a handful of contextual variations, sizes, states, and more
 */
class Button extends Component
{
    public $text;
    public $variant;
    public $type;
    public $btnType;
    public $btnSize;

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
     */
    public function __construct(
        $variant = 'secondary',
        $type = 'button',
        $text = '',
        $size = '',
        $icon = ''
    )
    {
        $this->text = $text ?? '';
        $this->btnType = $this->type = $type ?? '';
        $this->variant = $variant ?? '';
        if (!blank($icon)) {
            $iconClass = !empty($text) ? 'mr-2' : '';
            $this->text = '<i class="'.Arr::toCssClasses([$icon, $iconClass]).'"></i>'.$this->text;
            $this->btnType = 'button';
        }
        $this->btnSize = !empty($size) ? "btn-$size" : '';
    }
}
