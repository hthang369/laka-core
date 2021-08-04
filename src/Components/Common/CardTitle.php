<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class CardTitle extends Component
{
    public $tag;
    public $text;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'card-title';

    public function __construct(
        $text = '',
        $tag = 'h6'
    )
    {
        $this->tag = $tag;
        $this->text = $text;
    }
}
