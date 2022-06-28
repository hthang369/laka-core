<?php
namespace Laka\Core\Traits\Grids;

trait RendersGrid
{
    public function __toString()
    {
        return $this->toHtml();
    }

    public function toHtml()
    {
        return $this->render();
    }

    /**
     * Render the grid as HTML on the user defined view
     *
     * @return string
     * @throws \Throwable
     */
    public function render($data = [])
    {
        $newData = [
            'grid' => $this,
            'data' => array_merge($this->resultData, $data),
            'sectionCode' => $this->getSectionCode()
        ];
        return view($this->getGridView(), $newData)->render();
    }

    /**
     * Render the search form on the grid
     *
     * @return string
     * @throws \Throwable
     */
    public function renderSearchForm()
    {
        $params = func_get_args();
        $data = [
            // 'colSize' => $this->getGridToolbarSize()[0], // size
            'action' => $this->getSearchUrl(),
            'id' => $this->getSearchFormId(),
            'name' => $this->getSearchParam(),
            // 'dataAttributes' => [],
            'placeholder' => $this->getSearchPlaceholder(),
        ];

        return view($this->getSearchView(), $data)->render();
    }

    /**
     * Render the header info the grid
     *
     * @return string
     * @throws \Throwable
     */
    public function renderHeaderInfo()
    {
        $params = array_wrap(array_first(func_get_args()));

        $data = array_merge(array_only($this->resultData, ['total', 'currentPage', 'pages']), $params);

        return view($this->getHeaderInfoView(), $data)->render();
    }
}
