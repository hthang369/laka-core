<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

/**
 * Use Bootstrap custom <x-link> component for generating a standard <a> link. <x-link> supports the disabled state and click event propagation.
 */
class Link extends Component
{
    public $text;
    public $trim;
    public $attrs;
    public $collapse;

    /**
     * @param string $href
     * @param string $title
     * @param int $trim
     * @param string $text
     * @param array $collapse
     * @param string $target
     * @param string $class
     */
    public function __construct(
        $href = '',
        $title = '',
        $trim = 0,
        $text = '',
        $collapse = [],
        $target = '',
        $class = ''
    )
    {
        $this->text = $text ?? '';
        $this->trim = $trim ?? 0;
        $this->collapse = $collapse ?? [];
        $this->attrs = [
            'class' => $class ?? '',
            'href' => $href ?? '',
            'title' => $title ?? '',
            'target' => $target ?? '',
        ];
        if (isset($this->collapse['id'])) {
            $this->attrs['data-toggle'] =  'collapse';
            $this->attrs['data-target'] =  '#collapse-' . $this->collapse['id'];
            $this->attrs['href'] =  '#';
        }
        $this->attrs['class'] = Classes::get([
            $this->all['class'] ?? '',
            $this->attrs['class']
        ]);
        $this->attrs = \array_filter($this->attrs);
    }
}
