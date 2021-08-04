<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class Badge extends Component
{
    public $text;
    public $attrs;
    public $href;

    public function __construct(
        $href = '',
        $variant = '',
        $type = '',
        $text = '',
        $class = ''
    )
    {
        $this->href = $href ?? '';
        $this->text = $text ?? '';
        $this->attrs = [
            'class' => $class ?? '',
            'href' => $href ?? '',
        ];
        $this->attrs['class'] = Classes::get([
            'badge',
            $type ? 'badge-' . $type : '',
            $variant ? 'badge-' . $variant : '',
            $this->attrs['class']
        ]);
        $this->attrs = \array_filter($this->attrs);
    }
}
