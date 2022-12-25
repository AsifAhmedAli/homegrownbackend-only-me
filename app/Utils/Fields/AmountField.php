<?php
  
  
  namespace App\Utils\Fields;
  
  
  use TCG\Voyager\FormFields\AbstractHandler;

class AmountField extends AbstractHandler
{
  protected $codename = 'amount';
  
  public function createContent($row, $dataType, $dataTypeContent, $options)
  {
    return view('vendor.voyager.fields.amount', [
      'row' => $row,
      'options' => $options,
      'dataType' => $dataType,
      'dataTypeContent' => $dataTypeContent
    ]);
  }
}
