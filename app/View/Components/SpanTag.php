<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SpanTag extends Component
{
  public $description;
  public $style;
  
  /**
   * Create a new component instance.
   *
   * @param $description
   * @param string $style
   */
  public function __construct($description,  $style = "")
  {
    
    $this->description = $description;
    $this->style       = $style;
  }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.span-tag');
    }
}
