<?php

namespace Success\InviteBundle\Model;

/**
 * RefererRelation
 *
 * @author Gaston Caldeiro <chugas488@gmail.com>
 */
abstract class RefererRelation implements RefererRelationInterface {

  protected $refereable;
  protected $referer;
  
  public function __construct() {}

  public function __toString() {
    return sprintf('%s - %s', ucfirst($this->getRefereable()), ucfirst($this->getReferer()));
  }
  
  public function getRefereable() {
    return $this->refereable;
  }

  /**
   * Set refereable
   *
   * @param UserInterface $refereable
   * @return Message
   */
  public function setRefereable($refereable = null) {
    $this->refereable = $refereable;

    return $this;
  }

  /**
   * Get Referer
   *
   * @return UserInterface
   */
  public function getReferer() {
    return $this->referer;
  }

  /**
   * Set referer
   *
   * @param RefererInterface $referer
   * @return RefererInterface
   */
  public function setReferer($referer = null) {
    $this->referer = $referer;

    return $this;
  }

}
