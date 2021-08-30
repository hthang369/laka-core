<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class CardGroup extends Component
{
    public $layoutGroup;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'card-group';

    public function __construct(
        $cols = '1',
        $layout = '',
        $size = '',
        $sizeCols = '1'
    )
    {
        $group = empty($layout) ? "row row-cols-$cols" : "card-$layout";
        $this->layoutGroup = [$group];
        if (!empty($size) && empty($layout)) {
            array_push($this->layoutGroup, "row-cols-$size-$sizeCols");
        }
    }
}
