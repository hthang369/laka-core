<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class NavbarNav extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'navbar-nav';

    public $tag;
    public $class;

    /**
     * @param string $size
     * @param string $device
     */
    public function __construct(
        $tag = 'ul'
    )
    {
        $this->tag = $tag;
        $this->class = [
            'navbar-nav',
        ];
    }
}
