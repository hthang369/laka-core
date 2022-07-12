<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class CardText extends Component
{
    public $tag;
    public $text;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'card-text';

    /**
     * @param string $text
     * @param string $tag
     */
    public function __construct(
        $text = '',
        $tag = 'div'
    )
    {
        $this->tag = $tag;
        $this->text = $text;
    }
}
