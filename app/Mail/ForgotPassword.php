<?php

  namespace App\Mail;

  use App\Role;
  use App\User;
  use App\Utils\Constants\Constant;
  use Illuminate\Bus\Queueable;
  use Illuminate\Mail\Mailable;
  use Illuminate\Queue\SerializesModels;

  class ForgotPassword extends Mailable
  {
    use Queueable, SerializesModels;

    public $user;
    public $settings;
    public $provider;
    public $type;
    /**
     * @var string
     */
    public $userFullName;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $settings
     * @param string $provider
     * @param string $type
     */
    public function __construct(User $user, $settings, $provider = Constant::HGP, $type = 'reset')
    {
      $this->user = $user;
      $this->userFullName = ucwords($user->first_name .' '.$user->last_name);
      $this->settings = $settings;
      $this->provider = $provider;
      $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      if($this->type === 'new') {
        if($this->user->role_id === Role::NORMAL_USER_ROLE) {
          return $this->subject('Set Your Password')->view('emails.password.new');
        } else {
          $this->user->link = url("password/reset/{$this->user->reset_token}?type=new");
          return $this->subject('Set Your Password')->view('emails.password.new');
        }
      }
      if ($this->provider == Constant::HGP){
        return $this->subject(__('generic.mail.hgp.forgot_password.subject'))
            ->view('emails.reset.reset_password');
      } else {
        return
          $this->from(__('generic.mail.gx.from'))
              ->subject(setting('gx.forgot_email_subject'))
            ->view('emails.gx.reset.reset_password');
      }

    }
  }
