<?php
namespace Laka\Core\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Laka\Core\Traits\Pagination\BuildPaginator;

class BaseBuilder extends Builder
{
    use BuildPaginator;

    /**
     * Paginate the given query.
     *
     * @param  int|null  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginateClient($data = [], $perPage = null, $columns = [], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        $newData = is_object($data) ? $data : $this->model->newCollection($data);

        $results = ($total = $newData->count())
                        ? $newData->forPage($page, $perPage)->values()
                        : $newData;

        if (count($columns) > 0 && !in_array('*', $columns)) {
            $results = $results->only($columns);
        }

        return $this->paginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }
}
