<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class NavbarBrand extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'navbar-brand';

    public $target;
    public $href;

    /**
     * @param string $size
     * @param string $device
     */
    public function __construct(
        $href = null,
        $to = '',
        $target = ''
    )
    {
        $this->target = $target;
        $this->href = $href ?? $this->getRoute($to);
    }

    private function getRoute($to)
    {
        if (blank($to)) return '';
        $routeName = $to;
        $params = [];
        if (is_array($to)) {
            list($routeName, $params) = $to;
        }

        return route($routeName, $params);
    }
}
