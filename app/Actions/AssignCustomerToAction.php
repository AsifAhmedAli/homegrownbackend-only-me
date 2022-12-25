<?php


namespace App\Actions;


use App\Role;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use TCG\Voyager\Actions\AbstractAction;

class AssignCustomerToAction extends AbstractAction
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
        return route('admin.user.assign', ['user' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return  Helper::isAdmin() && (request()->segment(2) == 'customers' || request()->segment(2) == 'users');
    }

}
