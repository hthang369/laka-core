<?php
namespace Laka\Core\Traits\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait ResponseTrait
{
    protected function getViewName($key)
    {
        return data_get($this->listDefaultViewName, $key, $this->defaultName.'.'.$key);
    }

    protected function getMessageResponse($key)
    {
        $keyMessage = data_get($this->messageResponse, $key, null);
        return $keyMessage ? trans($keyMessage) : null;
    }

    /**
     * @param $class
     * @param $alias
     */
    public function setProperty($class, $alias)
    {
        $this->$alias = $class;
    }

    protected function setViewName($listViewName)
    {
        $this->listDefaultViewName = array_merge($this->listDefaultViewName, $listViewName);
    }

    protected function getRouteName($key, $params = [])
    {
        if (request()->wantsJson()) return '';
        $routeName = $this->getViewName($key);
        $route = Route::getRoutes()->getByName($routeName);
        if (is_null($route) || count($route->parameterNames()) == 0) {
            $params = [];
        }
        return route($routeName, $params);
    }

    /**
     * @param Request $request
     * @param $data
     * @param $viewName
     */
    protected function responseView(Request $request, $data, $viewName = '', $message = null)
    {
        return $this->response->data($request, $data, $viewName, $message);
    }

    /**
     * @param Request $request
     * @param $data
     * @param $viewName
     */
    protected function responseAction(Request $request, $data, $action, $viewName = '', $message = null, $errors = [])
    {
        switch($action) {
            case 'deleted':
                return $this->response->{$action}($request, $viewName, $message);
                break;
            case 'error':
            case 'serverError':
            case 'validationError':
                return $this->response->{$action}($request, $errors, $viewName, $message);
                break;
            default:
                return $this->response->{$action}($request, $data, $viewName, $message);
                break;
        }
    }
}
