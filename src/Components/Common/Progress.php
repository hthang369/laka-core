<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class Progress extends Component
{
    public $max;
    public $showProgress;
    public $showValue;
    public $animated;
    public $striped;
    public $variant;
    public $attrs;
    public $value;
    public $precision;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'progress';

    public function __construct(
        $max = '',
        $showProgress = false,
        $showValue = false,
        $class = '',
        $animated = false,
        $striped = false,
        $variant = '',
        $height = '',
        $value = 0,
        $precision = 0
    )
    {
        $this->max = $max ?: 100;
        $this->showProgress = $showProgress ?: false;
        $this->showValue = $showValue ?: false;
        $this->animated = $animated ?: false;
        $this->striped = $striped ?: false;
        $this->variant = $variant ?: '';
        $this->value = $value ?: 0;
        $this->precision = $precision ?: 0;
        $this->attrs = [
            'class' => $class ?: '',
        ];
        $this->attrs['class'] = Classes::get([
            'progress',
            $this->attrs['class']
        ]);
        if (!blank($height)) {
            data_set($this->attrs, 'style', "height: $height");
        }
        $this->attrs = \array_filter($this->attrs);
    }
}
