<?php

namespace App\View\Components\Dropdown;

use Illuminate\View\Component;

class GrowOperator extends Component
{
  public $value;
  public $name;
  public $valueName;
  
  /**
   * Create a new component instance.
   *
   * @param null $name
   * @param $value
   * @param null $valueName
   */
    public function __construct($name, $value = null, $valueName = null)
    {
        $this->value = $value;
        $this->name = $name;
        $this->valueName = $valueName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.dropdown.grow-operator');
    }
}
