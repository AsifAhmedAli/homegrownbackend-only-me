<?php


namespace App\Actions;


use App\Role;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use TCG\Voyager\Actions\AbstractAction;

class ViewPurchasedSubscriptionsAction extends AbstractAction
{

    public function getTitle()
    {
        return 'Subscriptions';
    }

    public function getIcon()
    {
        return 'voyager-tree';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right mr-1',
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.user-subscriptions', ['user_id' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return request()->segment(2) == 'customers' || request()->segment(2) == 'users';
    }

}
