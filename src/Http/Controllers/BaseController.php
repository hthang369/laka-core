<?php

namespace Laka\Core\Http\Controllers;

use Laka\Core\Contracts\BaseControllerInterface;
use Laka\Core\Http\Response\WebResponse;
use Laka\Core\Repositories\BaseRepository;
use Laka\Core\Support\Factory;
use Laka\Core\Validators\BaseValidator;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Laka\Core\Responses\BaseResponse;
use Laka\Core\Traits\Auth\Authorizable;
use Laka\Core\Traits\Common\ResponseTrait;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class BaseController extends Controller implements BaseControllerInterface
{
    use Authorizable, AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseTrait;
    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * @var BaseValidator
     */
    protected $validator;

    /**
     * @var BaseResponse
     */
    protected $response;

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

    protected $messageResponse = [];

    protected $data = [];

    /**
     * BaseController constructor.
     *
     * @param BaseValidator $validator
     */
    public function __construct(BaseRepository $repository, BaseValidator $validator, BaseResponse $response) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->response = $response;
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
    public function view(Request $request, $id = null)
    {
        if ($id) {
            return $this->show($request, $id);
        }
        return $this->index($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response|mixed
     * @throws Exception
     */
    public function index(Request $request)
    {
        $list = $this->repository->paginate();

        return $this->responseView($request, $list, $this->getViewName(__FUNCTION__), $this->getMessageResponse(__FUNCTION__));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response|mixed
     * @throws Exception
     */
    public function create(Request $request)
    {
        return $this->responseView($request, null, $this->getViewName(__FUNCTION__), $this->getMessageResponse(__FUNCTION__));
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
        $data = $this->repository->show($id);

        return $this->responseView($request, $data, $this->getViewName(__FUNCTION__), $this->getMessageResponse(__FUNCTION__));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response|mixed
     * @throws ValidatorException
     */
    public function store(Request $request)
    {
        $this->validator($request->all(), ValidatorInterface::RULE_CREATE);

        $data = $this->repository->create($request->all());

        if (method_exists($data, 'toArray')) {
            $data = $data->toArray();
        }

        return $this->responseAction($request, $data, 'created', $this->getRouteName(__FUNCTION__), $this->getMessageResponse(__FUNCTION__));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response|mixed
     * @throws Exception
     */
    public function show(Request $request, $id)
    {
        $data = $this->repository->show($id);

        return $this->responseView($request, $data, $this->getViewName(__FUNCTION__), $this->getMessageResponse(__FUNCTION__));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response|mixed
     * @throws ValidatorException
     */
    public function update(Request $request, $id)
    {
        $this->validator->setId($id);
        $this->validator($request->all(), ValidatorInterface::RULE_UPDATE);

        $data = $this->repository->update($request->all(), $id);

        if (method_exists($data, 'toArray')) {
            $data = $data->toArray();
        }

        return $this->responseAction($request, $data, 'updated', $this->getRouteName(__FUNCTION__, $id), $this->getMessageResponse(__FUNCTION__));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response|mixed
     */
    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);

        return $this->responseAction($request, null, 'deleted', $this->getRouteName(__FUNCTION__, $id), $this->getMessageResponse(__FUNCTION__));
    }

    /**
     * @param $data
     * @param $rules
     * @return mixed|void
     * @throws ValidatorException
     */
    public function validator($data, $rules)
    {
        $this->validator->with($data)->passesOrFail($rules);
    }
}
