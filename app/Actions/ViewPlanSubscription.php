<?php
  
  
  namespace App\Actions;
  
  
  use TCG\Voyager\Actions\AbstractAction;

  class ViewPlanSubscription extends AbstractAction
  {
    public function getTitle()
    {
      return 'Subscriptions';
    }
  
    public function getIcon()
    {
      return 'voyager-shop';
    }
  
    public function getAttributes()
    {
      return [
        'class' => 'btn btn-sm btn-primary pull-right',
      ];
    }
  
    public function getDefaultRoute()
    {
      return route('admin.plan.subscription', ['id' => $this->data->plan_id]);
    }
    
    public function shouldActionDisplayOnDataType()
    {
      return $this->dataType->slug == 'plans';
    }
  }
