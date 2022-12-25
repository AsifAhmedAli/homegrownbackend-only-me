<?php


namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class GrowLogDetailAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Logs';
    }

    public function getIcon()
    {
        return 'voyager-eye';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right mr-1',
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.grow-log-details.logs', ['log_id' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'grow-logs';
    }

}
