<?php
  
  
  namespace App\Utils\Fields;
  
  
  use TCG\Voyager\FormFields\AbstractHandler;

class CouponTypeFormField extends AbstractHandler
{
  protected $codename = 'Coupon Type';
  
  public function createContent($row, $dataType, $dataTypeContent, $options)
  {
    return view('voyager::fields.coupon-types', [
      'row' => $row,
      'options' => $options,
      'dataType' => $dataType,
      'dataTypeContent' => $dataTypeContent
    ]);
  }
}
