<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;
use Laka\Core\Helpers\Classes;

class Card extends Component
{
    public $title;
    public $header;
    public $footer;
    public $noBody;
    public $bodyAttr;
    public $attrs;
    public $prefix;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'card';

    public function __construct(
        $title = '',
        $header = '',
        $footer = '',
        $image = '',
        $class = '',
        $noBody = false,
        $bodyClass = ''
    )
    {
        $this->prefix = config('laka-core.prefix');
        $this->header = $header;
        $this->title = $title;
        $this->footer = $footer;
        $this->noBody = $noBody;
        $this->bodyAttr = ['class' => Classes::get(['card-body', $bodyClass])];
        $this->attrs = ['class' => Classes::get(['card', $class])];
    }
}
