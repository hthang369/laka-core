<?php

namespace Laka\Core\Components;

use Illuminate\View\Component as BaseComponent;

abstract class Component extends BaseComponent
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $prefix = config('laka-core.prefix');
        $viewName = data_get(config('laka-core.components'), $this->componentName.'.view');
        return "{$prefix}::{$viewName}";
    }
}
