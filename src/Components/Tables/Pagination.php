<?php

namespace Laka\Core\Components\Tables;

use Illuminate\Support\Arr;
use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class Pagination extends Component
{
    public $attrs;
    public $current;
    public $total;
    public $next;
    public $prev;
    public $pages;
    public $links;
    private $startPage = 1;
    private $numberOfPage = 5;
    private $firstNumber = false;
    private $lastNumber = false;
    public $except = [];

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'pagination';

    public function __construct(
        $current = '',
        $total = '',
        $next = [],
        $prev = [],
        $pages = '',
        $class = '',
        $except = []
    )
    {
        $this->current = $current ?: 0;
        $this->total = $total ?: 0;
        $this->pages = $pages ?: 0;
        $this->except = $except ?: [];
        $this->next = $next ?: $this->getNextUrl($this->current);
        $this->prev = $prev ?: $this->getPrevUrl($this->current);
        $this->attrs['class'] = Classes::get([
            'pagination',
            'class' => $class ?: '',
        ]);
        $this->attrs = \array_filter($this->attrs);
        $this->links = $this->getLinks();
        data_set($this->next, 'text', '<i class="fa fa-angle-right"></i>');
        data_set($this->prev, 'text', '<i class="fa fa-angle-left"></i>');
    }

    private function getLinks()
    {
        $endPage = $this->current + 2;
        $diff = $this->pages - $endPage;

        $start = max($this->current - 2, $this->startPage);
        if ($diff < 0 && $this->pages > 2)
            $start += $diff;

        $end = $start + min($this->numberOfPage, $this->pages) - 1;

        if ($start < 0) $start = $this->startPage;
        if ($end < 0) $end = $this->startPage;

        $links = collect(array_filter(range($start, $end)))->mapWithKeys(function ($page, $index) {
            return [$page => $this->getUrl($page, $index)];
        });

        if ($this->firstNumber) {
            $links->prepend($this->getUrl($this->startPage, null));
        }
        if ($this->lastNumber) {
            $links->push($this->getUrl($this->pages, null));
        }

        return $links->all();
    }

    private function getUrl($page, $index)
    {
        $label = $page;
        $url = $this->getCurrentUrlWithQuery($page);
        if ($index === 0 && $page != $this->startPage) {
            $this->firstNumber = true;
            $label = '...';
            $url = '';
        }
        if ($index === ($this->numberOfPage - 1) && $page != $this->pages) {
            $this->lastNumber = true;
            $label = '...';
            $url = '';
        }

        return [
            'label'  => $label,
            'url'    => $url,
            'active' => $this->current == $page
        ];
    }

    private function getPrevUrl($current)
    {
        $prevCurrent = $current - 1;
        return $prevCurrent < 0 ? [] : ['href' => $this->getCurrentUrlWithQuery($prevCurrent)];
    }

    private function getNextUrl($current)
    {
        $nextCurrent = $current + 1;
        return $nextCurrent > $this->pages ? [] : ['href' => $this->getCurrentUrlWithQuery($nextCurrent)];
    }

    private function getCurrentUrlWithQuery($pageNumber)
    {
        $query = array_except(request()->query(), $this->except);
        return url()->current().'?'.Arr::query(array_merge($query, ['page' => $pageNumber]));
    }
}
