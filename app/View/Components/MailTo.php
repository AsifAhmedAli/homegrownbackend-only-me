<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MailTo extends Component
{
    public $link;
    public $style;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link, $style="color:#000000;")
    {
        $this->link = $link;
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.mail-to');
    }
}
