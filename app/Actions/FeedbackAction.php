<?php


namespace App\Actions;


use App\Role;
use App\Utils\Constants\Constant;
use App\Utils\Helpers\Helper;
use TCG\Voyager\Actions\AbstractAction;

class FeedbackAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Feedback';
    }

    public function getIcon()
    {
        return 'voyager-bubble';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right mr-1',
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.grow-log-feedback.view', ['grow_log_detail_id' => $this->data->id]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'grow-log-details';
    }

}
