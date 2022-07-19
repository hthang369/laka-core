<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class NavbarToggle extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'navbar-toggle';

    public $attrs;

    /**
     * @param string $size
     * @param string $device
     */
    public function __construct(
        $target = '',
        $label = ''
    )
    {
        $this->attrs = [
            'class' => 'navbar-toggler',
        ];
        if (!blank($target)) {
            $this->attrs = array_merge($this->attrs, [
                'data-toggle' => 'collapse',
                'data-target' => "#{$target}",
                'aria-controls' => $target,
                'aria-expanded' => false
            ]);
        }
        if (!blank($label))
            data_set($this->attrs, 'aria-label', $label);
    }
}
