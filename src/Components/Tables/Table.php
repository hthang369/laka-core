<?php

namespace Laka\Core\Components\Tables;

use Laka\Core\Components\Component;
use Laka\Core\Traits\Grids\HasDataColumn;

class Table extends Component
{
    use HasDataColumn;

    public $items;
    public $fields;
    public $responsive;
    public $pagination;
    public $bordered;
    public $hover;
    public $stickyHeader;
    public $tableClass;
    public $isFilters;
    public $headerClass;
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'table';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $items,
        $fields = [],
        $responsive = null,
        $pagination = [],
        $bordered = true,
        $hover = false,
        $stickyHeader = false,
        $tableVariant = '',
        $headerVariant = '',
        $size = ''
    )
    {
        $this->bordered = $bordered;
        $this->hover = $hover;
        $this->tableClass = [
            'table',
            'table-bordered' => $this->bordered,
            'table-striped' => $this->bordered,
            'table-hover' => $this->hover
        ];
        $this->fields = $this->getFields($fields, $items);
        $this->items = $items;
        $this->pagination = $this->getPagination($pagination);
        $this->stickyHeader = $stickyHeader ?? false;
        $this->isFilters = count(array_filter($this->fields, function($item) {
            return (bool)$item->filtering;
        })) > 0;
        if (!is_null($responsive)) {
            $responsiveClass = is_string($responsive) ? $responsive : '';
            $this->responsive = sprintf('table-responsive%s', $responsiveClass);
        }
        if (!empty($tableVariant)) {
            array_push($this->tableClass, sprintf('table-%s', $tableVariant));
        }
        if (!empty($size)) {
            array_push($this->tableClass, sprintf('table-%s', $size));
        }
        if (!empty($headerVariant)) {
            $this->headerClass = sprintf('bg-%s', $headerVariant);
        }
    }
}
