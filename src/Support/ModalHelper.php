<?php

namespace Laka\Core\Support;

use Laka\Core\Facades\Common;

class ModalHelper
{
    public function start($modal)
    {
        return view(Common::getViewName('modal.modal-start'), compact('modal'))->render();
    }

    public function end($viewName = null, $data = null)
    {
        $view = $viewName ?? laka_component('modal.modal-buttons');
        return view(Common::getViewName('modal.modal-end'), compact('view', 'data'))->render();
    }
}
