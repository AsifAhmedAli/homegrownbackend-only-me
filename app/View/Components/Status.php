<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Status extends Component
{
  public $status;
  public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $status)
    {
        $this->status = $status;
        $this->resolveClass();
    }
    
    private function resolveClass()
    {
      if(strtolower($this->status) == 'active') {
        $this->class = 'badge-success';
      }
      if(strtolower($this->status) == 'canceled') {
        $this->class = 'badge-danger';
      }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.status');
    }
}
