<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class Row extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'row';

    public $tag;
    public $class;

    /**
     * @param string $size
     * @param string $device
     */
    public function __construct(
        $cols = '',
        $colsLg = '',
        $colsMd = '',
        $colsSm = '',
        $colsXl = '',
        $tag = 'div'
    )
    {
        $this->tag = $tag;
        $this->class = [
            'row',
            "row-cols-{$cols}" => !blank($cols),
            "row-cols-sm-{$colsSm}" => !blank($colsSm),
            "row-cols-md-{$colsMd}" => !blank($colsMd),
            "row-cols-lg-{$colsLg}" => !blank($colsLg),
            "row-cols-xl-{$colsXl}" => !blank($colsXl)
        ];
    }
}
