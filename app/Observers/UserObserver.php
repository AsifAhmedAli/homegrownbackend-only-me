<?php

namespace App\Observers;

use App\Mail\RegistrationConfirmationEmail;
use App\Mail\Welcome;
use App\Role;
use App\User;
use App\Utils\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class UserObserver
{
    public function created(User $user)
    {
      if(Helper::empty($user->password)) {
        Helper::resetPassword($user->email, 'new');
      }

      if($user->role_id == Role::GROW_MASTER_ROLE) {
          Helper::registerGrowMasterInDailyCo('GrowMaster-' . $user->id);
      }
    }

    public function creating(User $user)
    {
      $user->created_by = auth()->id();
    }

    public function saving(User $user)
    {
      if(isset($user->id)) {
        $user->updated_by = auth()->id();
      }
    }

    public function updating(User $user)
    {
        //
    }

    public function deleting(User $user)
    {
        if($user->role_id == Role::GROW_MASTER_ROLE) {
            Helper::removeGrowMasterInDailyCo($user->id);
        }
    }
}
