<?php

namespace Laka\Core\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use \Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\UnauthorizedException;
/*
 * A trait to handle authorization based on users permissions for given controller
 */

trait Authorizable
{
    use CommonFunction;

    protected $permissionActions = [];
    /**
     * Abilities: maps action controller with permission actions
     *
     * @var array
     */
    private $abilities =  [];

    private $tranActions = [
        'store',
        'update',
        'destroy'
    ];

    /**
     * Override of callAction to perform the authorization before it calls the action
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        // Skip permission check when run unit test
        if (app()->environment() === 'testing') {
            return $this->callPermissionAction($method, $parameters);
        }

        //check middleware multiple roles or permission
        if ($this->isMiddleWareRolesPermission()) {
            return $this->callPermissionAction($method, $parameters);
        }

        //check permission action
        if ($ability = $this->getAbility($method)) {
            if (!preg_match('/^public_/', $ability)) {
                $this->authorize($ability);
            }
            return $this->callPermissionAction($method, $parameters);
        }

        $auth = ['auth:api', 'web:api', 'auth:web'];
        $middleware = Request::route()->middleware();

        if (count(array_diff($auth, $middleware)) == 1) {
            throw UnauthorizedException::forPermissions([Request::route()->getName()]);
        } else {
            return $this->callPermissionAction($method, $parameters);
        }
    }

    final public function callPermissionAction($method, ...$params)
    {
        if (in_array($method, $this->tranActions)) {
            try {
                DB::beginTransaction();

                $data = parent::callAction($method, head($params));

                DB::commit();

                return $data;
            } catch (\Exception $ex) {
                DB::rollback();

                throw $ex;
            }
        } else {
            return parent::callAction($method, head($params));
        }
    }

    /*
     * Check middleware have multiple roles or permission
     * @return boolean
     */
    public function isMiddleWareRolesPermission()
    {
        $middleware = Request::route()->middleware();
        $guard = ['role', 'role_or_permission'];
        foreach ($middleware as $m) {
            $t  = explode(':', $m);
            if (in_array($t[0], $guard)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get ability
     *
     * @param $method
     * @return null|string
     */
    public function getAbility($method)
    {
        $routeName = explode('.', Request::route()->getName());
        $action = array_get($this->getAbilities(), $method);
        return $action ? $action . '_' . $routeName[0] : null;
    }

    /**
     * @return array
     */
    private function getAbilities()
    {
        return !empty($this->abilities) ? $this->abilities : config('permission.abilities');
    }

    /**
     * @param array $abilities
     */
    public function setAbilities($abilities)
    {
        $this->abilities = array_merge(config('permission.abilities'), $abilities);
    }
    /**
     * @param array $abilities
     */
    public function setControllerActionPermission($abilities)
    {
        $this->setAbilities($abilities);
    }
    /**
     * @param array $abilities
     */
    public function removeAbilities($abilitie_action)
    {
        if (isset($this->abilities[$abilitie_action])) {
            unset($this->abilities[$abilitie_action]);
        }
    }
}
