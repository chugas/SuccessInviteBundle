<?php

namespace Success\InviteBundle\Event;

use Success\InviteBundle\Model\RefererRelationInterface;
use Symfony\Component\EventDispatcher\Event;

class RefererRelationEvent extends Event {

  private $refererRelation;

  /**
   * Constructs an event.
   *
   * @param RefererRelationInterface $relation
   */
  public function __construct(RefererRelationInterface $refererRelation) {
    $this->refererRelation = $refererRelation;
  }

  /**
   * Returns the comment for this event.
   *
   * @return RefererRelationInterface
   */
  public function getRefererRelation() {
    return $this->refererRelation;
  }

}
