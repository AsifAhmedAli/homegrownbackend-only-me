<?php
  
  
  namespace App\Utils\Fields;
  
  
  use TCG\Voyager\FormFields\AbstractHandler;

  class TagField extends AbstractHandler
  {
    protected $codename = 'tags';
  
    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
      return view('voyager::fields.tags', [
        'row' => $row,
        'options' => $options,
        'dataType' => $dataType,
        'dataTypeContent' => $dataTypeContent
      ]);
    }
  }
