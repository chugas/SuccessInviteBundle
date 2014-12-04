<?php

namespace Success\InviteBundle\Manager;

use Success\InviteBundle\Model\RefererInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class RefererManager {

  protected $em;
  protected $class;
  protected $sessionKey;
  protected $_request;

  public function __construct(EntityManager $em, $class, $sessionKey) {
    $this->em = $em;
    $this->class = $class;
    $this->sessionKey = $sessionKey;
  }

  public function setRequest(Request $request = null) {
    $this->_request = $request;
  }
  
  public function getRequest(){
      return $this->_request;
  }

  /**
   * Get object repository for referer class
   *
   * @return ObjectManager
   */
  public function getRepository() {
    return $this->em->getRepository($this->class);
  }

  /**
   * Returns current referer
   *
   * @return RefererInterface object
   */
  public function getSessionReferer() {
    $session = $this->getRequest()->getSession();
    $refererInfo = null;

    if ($session->has($this->sessionKey)) {
      $refererInfo = $this->decode($session->get($this->sessionKey));
    } elseif ($this->getRequest()->cookies->has($this->sessionKey)) {
      $refererInfo = $this->decode($this->getRequest()->cookies->get($this->sessionKey));
    } else {
      return null;
    }

    if ($refererInfo != null) {
      $referer = $this->getRepository()->findOneById($refererInfo->id);
      if (!is_null($referer)) {
        return $referer;
      }
    }

    return null;
  }

  public function encode($value) {
    return base64_encode(json_encode($value));
  }

  public function decode($value) {
    return json_decode(base64_decode($value));
  }

}