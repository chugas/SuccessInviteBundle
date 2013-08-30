<?php

namespace Success\InviteBundle\EventListener;

use Success\InviteBundle\Events;
use Success\InviteBundle\Event\RefereableEvent;

class RefereableListener {

  protected $refererManager;
  protected $refererRelationManager;  

  public function __construct($refererManager, $refererRelationManager) {
    $this->refererManager = $refererManager;
    $this->refererRelationManager = $refererRelationManager;
  }

  public function onRefereablePersist(RefereableEvent $event) {
    $refereable = $event->getRefereable();
    $referer = $this->refererManager->getSessionReferer();
    if (!is_null($referer)) {
      $this->refererRelationManager->create($refereable, $referer);
    }
  }

  public static function getSubscribedEvents() {
    return array(
        Events::REFEREABLE_POST_PERSIST => 'onRefereablePersist'
    );
  }

}