<?php

namespace Laka\Core\Components\Common;

use Illuminate\View\ComponentAttributeBag;
use Laka\Core\Components\Component;

class NavItem extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'nav-item';

    public $target;
    public $href;
    public $linkAttrs;
    public $tag;

    /**
     * @param string $size
     * @param string $device
     */
    public function __construct(
        $href = null,
        $to = '',
        $target = '',
        $active = false,
        $activeClass = 'active',
        $linkAttrs = [],
        $tag = 'li'
    )
    {
        $this->target = $target;
        $this->tag = $tag;
        $this->href = $href ?? $this->getRoute($to);
        $this->linkAttrs = (new ComponentAttributeBag($linkAttrs))->class(['nav-link', $activeClass => $active]);
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
