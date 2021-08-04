<?php

namespace Laka\Core\Components\Common;

use Laka\Core\Components\Component;

class CardFooter extends Component
{
    public $text;

    /**
     * The component alias name.
     *
     * @var string
     */
    public $componentName = 'card-footer';

    public function __construct(
        $text = ''
    )
    {
        $this->text = $text;
    }
}
