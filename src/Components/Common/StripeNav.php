<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class StripeNav extends Component
{
    public $links;
    public $attrs;
    public $slot1;
    public $slot2;

    public function __construct(
        $all = [],
        $links = [],
        $class = ''
    )
    {
        $this->all = $all ?? '';
        $this->links = $links ?? '';
        $this->attrs = [
            'class' => $class ?? '',
        ];
        $this->attrs['class'] = Classes::get([
            'stripe-nav',
            $this->attrs['class']
        ]);
        $this->attrs = \array_filter($this->attrs);
    }
}
