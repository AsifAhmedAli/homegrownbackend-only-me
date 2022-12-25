<?php
  
  namespace App\View\Components;
  
  use Illuminate\View\Component;
  
  class AnchorTag extends Component
  {
    public $link;
    public $isAnchorTag;
    public $title;
    public $target;
    public $style;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link, $title, $style = "", $target = "_self", $isAnchorTag = true)
    {
      $this->link        = $link;
      $this->isAnchorTag = $isAnchorTag;
      $this->title       = $title;
      $this->target      = $target;
      $this->style       = $style;
    }
    
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
      return view('components.anchor-tag');
    }
  }
