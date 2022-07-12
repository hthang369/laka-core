<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class ProgressBar extends Component
{
    public $label;
    public $attrs;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'progress-bar';

    /**
     * @param int $max
     * @param int $precision
     * @param string $class
     * @param bool $animated
     * @param bool $striped
     * @param string $variant
     * @param int $value
     * @param bool $showProgress
     * @param bool $showValue
     */
    public function __construct(
        $max = 100,
        $precision = 0,
        $class = '',
        $animated = false,
        $striped = false,
        $variant = '',
        $value = 0,
        $showProgress = false,
        $showValue = false
    )
    {
        $bgVariant = blank($variant) ? '' : "bg-{$variant}";
        $valuePercent = ($value * 100) / $max;
        $this->label = '';
        if ($showProgress) {
            $valuePercent = round($valuePercent, $precision);
            $this->label = "{$valuePercent}%";
        }
        if ($showValue) {
            $this->label = round($value, $precision);
        }
        $this->attrs = [
            'class' => $class ?: '',
        ];
        $this->attrs['class'] = Classes::get([
            'progress-bar',
            'progress-bar-striped' => ($striped ?? false),
            'progress-bar-animated' => ($animated ?? false),
            $bgVariant,
            $this->attrs['class']
        ]);
        $this->attrs = \array_filter($this->attrs);
        data_set($this->attrs, 'aria-valuemax', $max ?? 100);
        data_set($this->attrs, 'aria-valuemin', 0);
        data_set($this->attrs, 'aria-valuenow', round($value));
        data_set($this->attrs, 'style', "width: {$valuePercent}%");
    }
}
