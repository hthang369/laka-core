<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class Navbar extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'navbar';

    public $tag;
    public $class;

    /**
     * @param string $size
     * @param string $device
     */
    public function __construct(
        $type = 'light',
        $variant = '',
        $sticky = false,
        $fixed = '',
        $toggleable = '',
        $tag = 'nav'
    )
    {
        $this->tag = $tag;
        $this->class = [
            'navbar',
            "navbar-{$type}" => !blank($type),
            "bg-{$variant}" => !blank($variant),
            "navbar-expand-{$toggleable}" => !blank($toggleable),
            "fixed-{$fixed}" => !blank($fixed),
            'sticky-top' => $sticky
        ];
    }
}
