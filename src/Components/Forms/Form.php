<?php

namespace Laka\Core\Components\Forms;

use Laka\Core\Components\Component;

class Form extends Component
{
    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'form';

    public $route;
    public $method;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route, $method = 'GET')
    {
        $this->route = $route;
        $this->method = $method;
    }
}
