<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class Breadcrumb extends Component
{
    public $attrs;
    public $pages;
    public $currentPage;

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
