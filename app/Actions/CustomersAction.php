<?php


namespace App\Actions;


use App\Role;
use App\Utils\Constants\Constant;
use TCG\Voyager\Actions\AbstractAction;

class CustomersAction extends AbstractAction
{

    public function getTitle()
    {
        $count = $this->data->children()->count();
        return 'Customers (' . $count . ')';
    }

    public function getIcon()
    {
        return 'voyager-people';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right mr-1',
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.users.customers', ['created_by' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'users' && $this->data->role_id == Role::RETAILER_ROLE;
    }

}
