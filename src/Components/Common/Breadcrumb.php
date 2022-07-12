<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

/**
 * Indicate the current page's location within a navigational hierarchy. Separators are automatically added in CSS through ::before and content.
 */
class Breadcrumb extends Component
{
    public $attrs;
    public $pages;
    public $currentPage;

    /**
     * @param string $class
     * @param string $currentPage
     * @param array $pages
     */
    public function __construct(
        $class = '',
        $currentPage = '',
        $pages = []
    )
    {
        $this->currentPage = $currentPage ?? '';
        $this->pages = $pages ?? [];
        $this->attrs = [
            'class' => $class ?? '',
        ];
        $this->attrs['class'] = Classes::get([
            'breadcrumb',
            $this->attrs['class']
        ]);
        $this->attrs = \array_filter($this->attrs);
    }
}
