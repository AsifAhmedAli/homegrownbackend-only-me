<?php
  
  
  namespace App\Utils\Traits;
  
  
  use App\User;

  trait SetterGetter
  {
    private $user;
  
    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
      $this->user = $user;
    }
  
    /**
     * @return User
     */
    public function getUser(): User
    {
      return $this->user;
    }
  }
