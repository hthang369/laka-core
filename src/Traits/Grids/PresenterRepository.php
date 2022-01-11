<?php

namespace Laka\Core\Traits\Grids;

use Laka\Core\Exceptions\RepositoryException;
use Laka\Core\Contracts\PresenterInterface;
use Laka\Core\Traits\Common\MakeObjectInstance;

trait PresenterRepository
{
    use MakeObjectInstance;
    /**
     * @var bool
     */
    protected $skipPresenter = false;

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return $this->presenterClass;
    }

    /**
     * Set Presenter
     *
     * @param $presenter
     *
     * @return $this
     */
    public function setPresenter($presenter)
    {
        $this->makePresenter($presenter);

        return $this;
    }

    /**
     * @param null $presenter
     *
     * @return PresenterInterface
     * @throws RepositoryException
     */
    public function makePresenter($presenter = null)
    {
        $presenter = $presenter ?? $this->presenter();

        $presenterObject = $this->makeObject($presenter);

        // if (!$presenterObject instanceof PresenterInterface) {
        //     throw new RepositoryException("Class {$presenter} must be an instance of Laka\\Core\\Contracts\\PresenterInterface");
        // }

        return $presenterObject;
    }
}
