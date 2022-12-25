<?php

  namespace App\Mail\GX;

  use Illuminate\Bus\Queueable;
  use Illuminate\Mail\Mailable;
  use Illuminate\Queue\SerializesModels;

  class SubscriptionConfirmationToAdmin extends Mailable
  {
    use Queueable, SerializesModels;

    private $userFullName;
    public  $heading;
    public  $body;
    public  $subscriptionName;
    public  $companyName;

    /**
     * Create a new message instance.
     *
     * @param string $userFullName
     * @param string $subscriptionName
     */
    public function __construct(string $userFullName, string $subscriptionName)
    {
      $this->subscriptionName     = $subscriptionName;
      $this->userFullName     = $userFullName;
      $this->companyName = setting('gx.company_name');
      $this->body        = __('generic.mail.gx.subscription_to_admin.body', ['userFullName'=>$this->userFullName,'subscriptionName' => $this->subscriptionName]);
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('emails.gx.kit.subscription_confirmation_to_admin')->with([
        'logo' => setting('gx.logo') ?? NULL,
      ])->from(__('generic.mail.gx.from'))->subject(__('generic.mail.gx.subscription_to_admin.subject', ['userFullName'=>$this->userFullName,'subscriptionName' => $this->subscriptionName]));
    }
  }
