<?php


  namespace App\Utils\Fields;


  use TCG\Voyager\FormFields\AbstractHandler;

class VideoField extends AbstractHandler
{
  protected $codename = 'video';

  public function createContent($row, $dataType, $dataTypeContent, $options)
  {
    return view('vendor.voyager.formfields.video', [
      'row' => $row,
      'options' => $options,
      'dataType' => $dataType,
      'dataTypeContent' => $dataTypeContent
    ]);
  }
}
