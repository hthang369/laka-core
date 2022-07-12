<?php

namespace Laka\Core\Http\Controllers;

use Illuminate\Http\Request;
use Laka\Core\Http\Controllers\BaseController;
use Laka\Core\Http\Response\JsonResponse;
use Laka\Core\Http\Response\WebResponse;
use Laka\Core\Validators\BaseValidator;
use Illuminate\Support\Facades\View;
use Laka\Core\Repositories\BaseRepository;
use Laka\Core\Responses\BaseResponse;
use Laka\Core\Forms\FormBuilder;
use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class CoreController
 * @package App\Http\Controllers\Core
 */
abstract class CoreController extends BaseController
{
    protected $layoutModuleName;

    protected $routeName;

    protected $formBuilder;

    public function __construct(BaseRepository $repository, BaseValidator $validator, BaseResponse $response)
    {
        $this->initViewName();

        parent::__construct($repository, $validator, $response);
        $this->formBuilder = resolve(FormBuilder::class);

        View::share('sectionCode', $this->routeName);
    }

    protected function initViewName()
    {
        if (!$this->routeName)
            $this->routeName = $this->getSectionCode();
        $listViewName = $this->loadConfig(config('laka.views'), $this->defaultName);
        $listViewName = $this->loadTemplateViewsConfig($listViewName);
        $listRouteName = $this->loadConfig(config('laka.routes.success'), $this->routeName, false);
        $listRouteErrorName = $this->loadConfig(config('laka.routes.errors'), $this->routeName, false);
        $this->listViewName += $listViewName + $listRouteName;
        $this->errorRouteName += $listRouteErrorName;
    }

    protected function getData($data = null)
    {
        $presenterGrid = method_exists($this->repository, 'getPresenterGrid') ? $this->repository->getPresenterGrid() : null;
        array_push($this->data, $presenterGrid, $data);
        list($grid, $result) = $this->data;
        return compact('grid', 'result');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response|mixed
     * @throws Exception
     */
    public function index(Request $request)
    {
        list($grid, $result) = $this->repository->allDataGrid();

        return $this->responseView($request, compact('grid', 'result'), $this->getViewName(__FUNCTION__), $this->getMessageResponse(__FUNCTION__));
    }

    public function create(Request $request)
    {
        list($modal, $form) = $this->formGenerateConfig(route($this->routeName.'.store'), __FUNCTION__);

        return $this->responseView($request, compact('modal', 'form'), $this->getViewName(__FUNCTION__), $this->getMessageResponse(__FUNCTION__));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response|mixed
     * @throws Exception
     */
    public function edit(Request $request, $id)
    {
        $base = $this->repository->show($id);

        list($modal, $form) = $this->formGenerateConfig(route($this->routeName.'.update', data_get($base, 'id', $id)), 'update', ['method' => 'put', 'model' => $base]);

        return $this->responseView($request, compact('modal', 'form'), $this->getViewName(__FUNCTION__), $this->getMessageResponse(__FUNCTION__));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, $id)
    {
        $base = $this->repository->show($id);

        list($modal, $form) = $this->formGenerateConfig(route($this->routeName.'.update', data_get($base, 'id', $id)), 'detail', ['method' => 'put', 'model' => $base]);

        return $this->responseView($request, compact('modal', 'form'), $this->getViewName(__FUNCTION__), $this->getMessageResponse(__FUNCTION__));
    }

    protected function formGenerateConfig($routeLink, $actionName, $options = [])
    {
        list($modal, $formData) = $this->repository->formGenerate($routeLink, $actionName, $options);
        $formField = $this->formBuilder->create($formData, $modal);
        // $this->validator->loadInitRule(ValidatorInterface::RULE_CREATE, $formField->getFieldsRules());
        $form = $formField->renderForm([], false, true, false);

        return [$modal, $form];
    }

    private function loadConfig(&$data, $prefix, $isView = true)
    {
        $moduleName = $this->getLayoutModuleName();
        $prefix = $isView ? module_views_path($moduleName, $prefix) : $prefix;
        array_walk($data, function(&$item, $key, $prefix) {
            $item = sprintf($item, $prefix);
        }, $prefix);

        return $data;
    }

    private function loadTemplateViewsConfig(&$data)
    {
        $temps = config('laka.views_temp');
        array_walk($data, function(&$view, $key) use($temps) {
            if (!View::exists($view)) {
                $view = data_get($temps, $key, $view);
            }
            return $view;
        });
        return $data;
    }
}
