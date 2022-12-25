<?php

namespace App\View\Components\label;

use Illuminate\View\Component;

class no extends Component
{
  public $text;
  
  /**
   * Create a new component instance.
   *
   * @param string $text
   */
  public function __construct($text = 'No')
  {
      $this->text = $text;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
      return view('components.label.no');
  }
}
