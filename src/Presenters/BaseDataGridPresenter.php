<?php

namespace Laka\Core\Presenters;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Laka\Core\Contracts\PresenterInterface;
use Laka\Core\Helpers\Classes;
use Laka\Core\Traits\HasDataColumn;

abstract class BaseDataGridPresenter implements PresenterInterface
{
    use HasDataColumn;

    private $fields = [];
    private $actionName = 'action';

    protected $actionColumnOptions = [];
    private $template = [
        'fields'        => [],
        'rows'          => [],
        'total'         => 0,
        'pages'         => 0,
        'currentPage'   => 0,
        'from'          => 0,
        'to'            => 0
    ];

    protected function setColumns()
    {
        return [];
    }

    private function getActionOptions()
    {
        $prefix = config('laka-core.prefix');
        return array_merge(['sortable' => false, 'cell' => "$prefix::tables.buttons.action", 'dataType' => 'buttons'], $this->actionColumnOptions);
    }

    protected function getColumns()
    {
        $fields = collect($this->fields);
        $fields = $fields->merge($this->setColumns());
        $actionColumn = $this->getField($this->actionName, translate('table.action'), $this->getActionOptions());
        $actionColumn['class'] = Classes::get(['table-action', $actionColumn['class']]);
        $fields->push($actionColumn);

        return $fields->all();
    }

    private function parseRows($data)
    {
        return collect($data->items())->map(function(&$item, $key) use($data) {
            if (method_exists($this, 'customizeRowData')) {
                $itemData = ['from' => $data->firstItem(), 'to' => $data->lastItem(), 'data' => $item, 'index' => $key];
                $item = data_get(call_user_func([$this, 'customizeRowData'], $itemData), 'data');
            }
            if (blank($item->{$this->actionName})) {
                $actions = [
                    $this->getEditActionBtn($item),
                    $this->getDetailActionBtn($item),
                    $this->getDeleteActionBtn($item)
                ];
                data_set($item, $this->actionName, $actions);
            }
            return $item;
        })->all();
    }

    private function getEditActionBtn($item)
    {
        return $this->getFieldButton('edit', '', [
            'class' => 'btn-primary',
            'icon' => 'far fa-edit',
            'title' => translate('table.btn_edit'),
            'visible' => $this->visibleEdit($item)
        ]);
    }

    private function getDetailActionBtn($item)
    {
        return $this->getFieldButton('show', '', [
            'class' => 'btn-info',
            'icon' => 'fas fa-info-circle',
            'title' => translate('table.btn_detail'),
            'visible' => $this->visibleDetail($item)
        ]);
    }

    private function getDeleteActionBtn($item)
    {
        return $this->getFieldButton('destroy', '', [
            'class' => 'btn-danger',
            'icon' => 'far fa-trash-alt',
            'title' => translate('table.btn_delete'),
            'visible' => $this->visibleDelete($item)
        ]);
    }

    protected function visibleEdit($item)
    {
        return true;
    }

    protected function visibleDetail($item)
    {
        return true;
    }

    protected function visibleDelete($item)
    {
        return true;
    }

    /**
     * Prepare data to present
     *
     * @param $data
     *
     * @return mixed
     */
    public function present($results)
    {
        if ($results instanceof LengthAwarePaginator) {
            return $this->parsePresent($results, $results->total());
        }
        return $results;
    }

    protected function parsePresent($results, $total)
    {
        return array_merge($this->template, [
            'fields'        => $this->getColumns(),
            'rows'          => method_exists($results, 'items') ? $this->parseRows($results) : $results,
            'total'         => $total,
            'pages'         => method_exists($results, 'lastPage') ? $results->lastPage() : 0,
            'currentPage'   => method_exists($results, 'currentPage') ? $results->currentPage() : 0,
            'from'          => method_exists($results, 'firstItem') ? $results->firstItem() : 0,
            'to'            => method_exists($results, 'lastItem') ? $results->lastItem() : 0
        ]);
    }
}
