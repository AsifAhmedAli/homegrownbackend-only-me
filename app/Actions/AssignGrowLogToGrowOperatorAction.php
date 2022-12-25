<?php


namespace App\Actions;


use App\Role;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use TCG\Voyager\Actions\AbstractAction;

class AssignGrowLogToGrowOperatorAction extends AbstractAction
{

    public function getTitle()
    {
        return 'Assign';
    }

    public function getIcon()
    {
        return 'voyager-external';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right mr-1',
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.grow-log.assign', ['growLog' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'grow-logs' && Helper::isAdmin();
    }

}
