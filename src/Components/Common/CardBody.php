<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class CardBody extends Component
{
    public $tag;
    public $bodyClass;
    public $title;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'card-body';

    /**
     * @param string $tag
     * @param string $bgVariant
     * @param string $borderVariant
     * @param string $title
     */
    public function __construct(
        $tag = 'div',
        $bgVariant = '',
        $borderVariant = '',
        $title = ''
    )
    {
        $this->tag = $tag;
        $this->title = $title;
        $this->bodyClass = array_filter(['card-body', $bgVariant, $borderVariant]);
    }
}
