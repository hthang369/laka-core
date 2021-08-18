<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class Button extends Component
{
    public $text;
    public $variant;
    public $type;
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
        $size = ''
    )
    {
        $this->text = $text ?? '';
        $this->type = $type ?? '';
        $this->variant = $variant ?? '';
        $this->btnSize = !empty($size) ? "btn-$size" : '';
    }
}
