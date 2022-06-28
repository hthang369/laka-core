<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class CardBody extends Component
{
    public $tag;
    public $bodyClass;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'card-body';

    public function __construct(
        $tag = 'div',
        $bgVariant = '',
        $borderVariant = '',
        $title = ''
    )
    {
        $this->tag = $tag;
        $this->bodyClass = array_filter(['card-body', $bgVariant, $borderVariant]);
    }
}
