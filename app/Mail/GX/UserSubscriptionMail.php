<?php

  namespace App\Mail\GX;

  use Illuminate\Bus\Queueable;
  use Illuminate\Mail\Mailable;
  use Illuminate\Queue\SerializesModels;

  class UserSubscriptionMail extends Mailable
  {
    use Queueable, SerializesModels;

    private $userFullName;
    public  $heading;
    public  $body;
    public  $kitName;
    public  $companyName;

    /**
     * Create a new message instance.
     *
     * @param string $userFullName
     * @param string $kitName
     */
    public function __construct(string $userFullName, string $kitName)
    {
      $this->kitName     = $kitName;
      $this->userFullName     = $userFullName;
      $this->companyName = setting('gx.company_name');
      $this->body        = __('generic.mail.gx.subscription.body', ['kitName' => $this->kitName]);
      $this->heading     = __('generic.mail.gx.subscription.heading', ['name' => $this->userFullName]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('emails.gx.kit.subscription')->with([
        'logo' => setting('gx.logo') ?? NULL,
      ])->from(__('generic.mail.gx.from'))->subject(__('generic.mail.gx.subscription.subject'));
    }
  }
