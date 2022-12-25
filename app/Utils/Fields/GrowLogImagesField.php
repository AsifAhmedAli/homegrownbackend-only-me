<?php


namespace App\Utils\Fields;


use TCG\Voyager\FormFields\AbstractHandler;

class GrowLogImagesField extends AbstractHandler
{
    protected $codename = 'grow_log_images';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('vendor.voyager.fields.grow-log-images', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
