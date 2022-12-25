<?php


namespace App\Actions;


use App\Role;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use TCG\Voyager\Actions\AbstractAction;

class ViewPurchasedKitsAction extends AbstractAction
{

    public function getTitle()
    {
        return 'Kits';
    }

    public function getIcon()
    {
        return 'voyager-basket';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right mr-1',
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.user-kits', ['user_id' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return request()->segment(2) == 'customers' || request()->segment(2) == 'users';
    }

}
