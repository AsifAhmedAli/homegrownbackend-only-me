<?php
  
  
  namespace App\Actions;
  
  
  use TCG\Voyager\Actions\AbstractAction;

  class ReplyToSupportTicket extends AbstractAction
  {
    public function getTitle()
    {
      return 'Messages';
    }
  
    public function getIcon()
    {
      return 'voyager-documentation';
    }
  
    public function getAttributes()
    {
      return [
        'class' => 'btn btn-sm btn-primary pull-right mr-1',
      ];
    }
  
    public function getDefaultRoute()
    {
      return route('admin.ticket.reply', ['ticket' => $this->data->id]);
    }
    
    public function shouldActionDisplayOnDataType()
    {
      return $this->dataType->slug == 'tickets';
    }
  }
