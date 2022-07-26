<?php
namespace Laka\Core\Traits\Pagination;

use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;
use Laka\Core\Pagination\LakaPagination;

trait BuildPaginator
{
    protected function paginator($items, $total, $perPage, $currentPage, $options)
    {
        $options = array_merge($options, ['path' => Paginator::resolveCurrentPath()]);
        return Container::getInstance()->makeWith(LakaPagination::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}
