<?php
namespace Laka\Core\Traits\Grids;

use Laka\Core\Contracts\PresenterInterface;

trait PresenterDataGrid
{
    use PresenterRepository;

    /**
     * @var PresenterInterface
     */
    protected $presenterGrid;

    public function bootPresenterDataGrid()
    {
        $this->presenterGrid = $this->makePresenter($this->presenterClass);
    }

    protected function parserResult($result)
    {
        if ($this->presenterGrid instanceof PresenterInterface) {
            return $this->presenterGrid->present($result);
        }
        return parent::parserResult($result);
    }

    public function getPresenterGrid()
    {
        return $this->presenterGrid;
    }
}
