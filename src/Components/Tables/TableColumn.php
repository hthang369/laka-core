<?php

namespace Laka\Core\Components\Tables;

use Laka\Core\Components\Component;
use Laka\Core\Grids\DataColumn;

class TableColumn extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'table-column';

    public $tag;
    public $field;
    public $cellData;
    public $isRowHeader;
    public $rowType;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(DataColumn $field, $data = null, $isHeader = false, $rowType = 'row')
    {
        $this->field = $field;
        $this->cellData = $data;
        $this->isRowHeader = $isHeader;
        $this->rowType = $rowType;
        $this->tag = $isHeader ? 'th' : 'td';
    }
}
