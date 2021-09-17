<?php

namespace Laka\Core\Http\Controllers;

use Laka\Core\Contracts\BaseControllerInterface;
use Laka\Core\Http\Response\WebResponse;
use Laka\Core\Repositories\BaseRepository;
use Laka\Core\Support\Factory;
use Laka\Core\Traits\Authorizable;
use Laka\Core\Validators\BaseValidator;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class BaseController extends Controller implements BaseControllerInterface
{
    use Authorizable, AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * @var BaseValidator
     */
    protected $validator;

    /**
     * @var Factory
     */
    protected $factory;

    protected $defaultName;

    protected $listDefaultViewName = [
        'index'     => '',
        'create'    => '',
        'show'      => '',
        'store'     => '',
        'update'    => '',
        'destroy'   => ''
    ];

    protected $listViewName = [];

    protected $errorRouteName = [];

    /**
     * BaseController constructor.
     *
     * @param BaseValidator $validator
     */
    public function __construct(BaseValidator $validator) {
        $this->validator = $validator;
        $this->factory = new Factory($this);
        $this->setControllerActionPermission($this->permissionActions);
        $this->setViewName($this->listViewName);
    }

    /**
     * Display a listing or the specified resource.
     *
     * @param null $id
     * @return Response|mixed
     * @throws Exception
     */
    public function view($id = null) {
        if ($id) {
            return $this->show($id);
        }
        return $this->index();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response|mixed
     * @throws Exception
     */
    public function index() {
        $list = $this->repository->paginate();

        return WebResponse::success($this->getViewName(__FUNCTION__), $list);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response|mixed
     * @throws Exception
     */
    public function create() {
        $data = null;
        return WebResponse::success($this->getViewName(__FUNCTION__), $data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response|mixed
     * @throws Exception
     */
    public function edit($id) {
        $data = $this->repository->show($id);
        return WebResponse::success($this->getViewName(__FUNCTION__), $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response|mixed
     * @throws ValidatorException
     */
    public function store(Request $request) {
        try {
            $this->validator($request->all(), ValidatorInterface::RULE_CREATE);

            $data = $this->repository->create($request->all());

            if (method_exists($data, 'toArray')) {
                $data = $data->toArray();
            }

            return WebResponse::created(route($this->getViewName(__FUNCTION__)), $data);
        } catch (ValidatorException $e) {
            return WebResponse::validateFail(route($this->getErrorRouteName(__FUNCTION__)), $e->getMessageBag());
        } catch (\Exception $e) {
            return WebResponse::exception(route($this->getErrorRouteName(__FUNCTION__)), null, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response|mixed
     * @throws Exception
     */
    public function show($id) {
        $data = $this->repository->show($id);
        return WebResponse::success($this->getViewName(__FUNCTION__), $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response|mixed
     * @throws ValidatorException
     */
    public function update(Request $request, $id) {
        try {
            $this->validator->setId($id);
            $this->validator($request->all(), ValidatorInterface::RULE_UPDATE);

            $data = $this->repository->update($request->all(), $id);

            if (method_exists($data, 'toArray')) {
                $data = $data->toArray();
            }

            return WebResponse::updated(route($this->getViewName(__FUNCTION__), $id), $data);
        } catch (ValidatorException $e) {
            return WebResponse::validateFail(route($this->getErrorRouteName(__FUNCTION__), $id), $e->getMessageBag());
        } catch (\Exception $e) {
            return WebResponse::exception(route($this->getErrorRouteName(__FUNCTION__), $id), null, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response|mixed
     */
    public function destroy($id) {
        $this->repository->delete($id);

        return WebResponse::deleted(route($this->getViewName(__FUNCTION__), $id));
    }

    /**
     * @param $data
     * @param $rules
     * @return mixed|void
     * @throws ValidatorException
     */
    public function validator($data, $rules) {
        $this->validator->with($data)->passesOrFail($rules);
    }

    protected function getViewName($key)
    {
        return data_get($this->listDefaultViewName, $key, $this->defaultName.'.'.$key);
    }

    protected function getErrorRouteName($key)
    {
        return data_get($this->errorRouteName, $key, '');
    }

    /**
     * @param $class
     * @param $alias
     */
    public function setProperty($class, $alias) {
        $this->$alias = $class;
    }

    protected function setViewName($listViewName)
    {
        $this->listDefaultViewName = array_merge($this->listDefaultViewName, $listViewName);
    }
}
