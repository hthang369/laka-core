<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

/**
 * Small and adaptive tag for adding context to just about any content.
 */
class Badge extends Component
{
    public $text;
    public $attrs;
    public $href;

    /**
     * @param string $href  Denotes the target URL of the link for standard a links
     * @param string $variant  Applies one of the Bootstrap theme color variants to the component
     * @param string $pill  When set to 'true', renders the badge in pill style
     * @param string $text  Show text in badge to the component
     * @param string $class  Applies class name to the component
     */
    public function __construct(
        $href = '',
        $variant = 'secondary',
        $pill = false,
        $text = '',
        $class = ''
    )
    {
        $this->href = $href ?? '';
        $this->text = $text ?? '';
        $this->attrs = [
            'class' => $class ?? '',
            'href' => $href ?? '',
        ];
        $this->attrs['class'] = Classes::get([
            'badge',
            'badge-pill' => $pill,
            $variant ? 'badge-' . $variant : '',
            $this->attrs['class']
        ]);
        $this->attrs = \array_filter($this->attrs);
    }
}
