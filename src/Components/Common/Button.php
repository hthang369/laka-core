<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

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
            $this->text = '<i class="'.$icon.'"></i>';
            $this->btnType = 'button';
        }
        $this->btnSize = !empty($size) ? "btn-$size" : '';
    }
}
