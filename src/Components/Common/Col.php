<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class Col extends Component
{
    public $class;
    public $tag;
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'col';

    /**
     * @param string|int $cols
     * @param string|int|bool $sm
     * @param string|int|bool $md
     * @param string|int|bool $lg
     * @param string|int|bool $xl
     */
    public function __construct(
        $cols = '',
        $sm = '',
        $md = '',
        $lg = '',
        $xl = '',
        $tag = 'div'
    )
    {
        $valSm = $this->convertBreakpoint($sm);
        $valMd = $this->convertBreakpoint($md);
        $valLg = $this->convertBreakpoint($lg);
        $valXl = $this->convertBreakpoint($xl);
        $this->class = [
            "col" => blank($cols),
            "col-{$cols}" => !blank($cols),
            "col-sm{$valSm}" => !blank($sm),
            "col-md{$valMd}" => !blank($md),
            "col-lg{$valLg}" => !blank($lg),
            "col-xl{$valXl}" => !blank($xl)
        ];
        $this->tag = $tag;
    }

    private function convertBreakpoint($breakpoint)
    {
        if (is_bool($breakpoint)) return '';
        $val = abs($breakpoint) * -1;
        return $val == 0 ? "-{$breakpoint}" : $val;
    }
}
