<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class CardHeader extends Component
{
    public $tag;
    public $text;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'card-header';

    public function __construct(
        $text = '',
        $tag = 'h4'
    )
    {
        $this->tag = $tag;
        $this->text = $text;
    }
}
