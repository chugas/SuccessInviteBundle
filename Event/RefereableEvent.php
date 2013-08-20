<?php

namespace Success\InviteBundle\Event;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\EventDispatcher\Event;

class RefereableEvent extends Event {

  private $refereable;

  /**
   * Constructs an event.
   *
   * @param UserInterface $refereable
   */
  public function __construct(UserInterface $refereable) {
    $this->refereable = $refereable;
  }

  /**
   * Returns the comment for this event.
   *
   * @return UserInterface
   */
  public function getRefereable() {
    return $this->refereable;
  }

}
