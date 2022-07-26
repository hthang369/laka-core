<?php

namespace Laka\Core\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Laka\Core\Traits\Common\MakeObjectInstance;
use Laka\Core\Traits\Grids\PresenterDataGrid;

/**
 * Class BaseRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
abstract class CoreRepository extends BaseRepository
{
    use MakeObjectInstance, PresenterDataGrid;
    /**
     * $var service;
     */
    protected $service;

    /**
     * $var form;
     */
    protected $formData;

    protected $presenterClass;

    /**
     * Specify Service class name
     *
     * @return string
     */
    public function service()
    {
        return null;
    }

    /**
     * Specify Form class name
     *
     * @return string
     */
    public function form()
    {
        return null;
    }

    /**
     * @param null $service
     *
     * @return mixin
     * @throws RepositoryException
     */
    public function makeService($service = null)
    {
        $serviceClass = $service ?? $this->service();

        $this->service = $this->makeObject($serviceClass);

        return $this->service;
    }

    /**
     * @param null $form
     *
     * @return mixin
     * @throws RepositoryException
     */
    public function makeFormData($form = null)
    {
        $formClass = $form ?? $this->form();

        $this->formData = $this->makeObject($formClass);

        return $this->formData;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    protected function boot()
    {
        $this->makeService();
        $this->makeFormData();
    }

    public function unguard()
    {
        $this->model::unguard();
    }

    public function reguard()
    {
        $this->model::reguard();
    }

    protected function postFilterByRequest(Builder $query)
    {
        if (method_exists($this, 'apply')) {
            $query = call_user_func([$this, 'apply'], $query);
        }
        return $this->defaultOrderBy($query);
    }

    public function allDataGrid()
    {
        if ($this->presenterGrid) {
            $data = $this->paginate();
            return [$this->presenterGrid, $data];
        }
        return [];
    }

    protected function getGridParams()
    {
        return [
            'query' => $this->getQuery(),
            'request' => request()
        ];
    }

    protected function getQuery()
    {
        $this->applyCriteria();
        $this->applyScope();

        if ($this->model instanceof Builder)
            $results = $this->model;
        else
            $results = $this->model::query();

        $this->resetModel();
        $this->resetScope();

        return $results;
    }

    public function formGenerate($route, $actionName, $config = [])
    {
        $modal = [
            'model' => $this->model,
            'route' => $route,
            'action' => $actionName,
            'pjaxContainer' => request()->get('ref'),
            'title' => ucwords($actionName).' '.class_basename($this->model)
        ];

        $modal = array_merge($modal, $config);

        return [$modal, $this->form()];
    }

    public function getCreatedUpdatedUser()
    {
        $data[] = $this->model::getUpdatedUser();
        if (!$this->model->exists) array_unshift($data, $this->model::getCreatedUser());
        return array_fill_keys($data, $this->model->getAuthUser());
    }

    public function getSelectedList($column, $key = null, $defaultText = null, $defaultValue = 0)
    {
        $results = $this->pluck($column, $key);
        if (is_null($defaultText) && is_null($defaultValue))
            return $results;

        if (is_object($results))
            return $results->prepend($defaultText, $defaultValue)->sort();

        return array_prepend($results, $defaultText, $defaultValue);
    }
}
