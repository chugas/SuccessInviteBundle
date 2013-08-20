<?php

namespace Success\InviteBundle\EventListener;

use Success\InviteBundle\Events;
use Success\InviteBundle\Event\RefereableEvent;

class RefereableListener {

  protected $refererManager;

  public function __construct($refererManager) {
    $this->refererManager = $refererManager;
  }

  public function onRefereablePersist(RefereableEvent $event) {
    $refereable = $event->getRefereable();
    $referer = $this->refererManager->getSessionReferer();
    if (!is_null($referer)) {
      $this->refererManager->create($refereable, $referer);
    }
  }

  public static function getSubscribedEvents() {
    return array(
        Events::REFEREABLE_POST_PERSIST => 'onRefereablePersist'
    );
  }

}