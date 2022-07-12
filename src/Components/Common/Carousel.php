<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

/**
 * The <x-carousel> component is a slideshow for cycling through a series of content, built with CSS 3D transforms. It works with a series of images, text, or custom markup.
 */
class Carousel extends Component
{
    public $attrs;
    public $items;
    public $indicators;
    public $control;

    /**
     * @param array $items
     * @param bool $indicators
     * @param bool $control
     * @param string $class
     * @param string $id
     */
    public function __construct(
        $items = [],
        $indicators = false,
        $control = false,
        $class = '',
        $id = ''
    )
    {
        $this->items = $items ?? [];
        $this->indicators = $indicators ?? false;
        $this->control = $control ?? false;
        $this->attrs = [
            'class' => 'carousel slide ' . ($class ?? ''),
            'id' => $id ?? '',
        ];
        $this->attrs = \array_filter($this->attrs);
    }
}
