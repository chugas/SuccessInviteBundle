<?php

namespace Success\InviteBundle\EventListener;

use Success\InviteBundle\Matcher\MatcherInterface;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class RefererListener {

  protected $sessionKey;

  protected $matcher;
  
  protected $refererInfo;
  
  protected $reloadCache;

  /**
   * Class constructor
   *
   * @param string $sessionKey
   * @param string $matcher
   */
  public function __construct($sessionKey, MatcherInterface $matcher) {
    $this->sessionKey = $sessionKey;
    $this->matcher = $matcher;
    $this->refererInfo = null;
    $this->reloadCache = false;
  }

  public function onRequest(GetResponseEvent $event) {
    $request = $event->getRequest();
    $session = $request->getSession();
    
    if($session->has($this->sessionKey)){
      return true;
    }
    if($request->cookies->has($this->sessionKey)){
      $this->refererInfo = $this->decode($request->cookies->get($this->sessionKey));
      $session->set($this->sessionKey, $this->encode($this->refererInfo));
      return true;
    }
    
    if(null != $referer = $this->matcher->match($request)){
      $this->refererInfo = array(
        'id' => $referer->getId(),
        'ref'=> $referer->getSlug()
      );
      $session->set($this->sessionKey, $this->encode($this->refererInfo));
      $this->reloadCache = true;
    }
  }

  public function onResponse(FilterResponseEvent $event) {
    $response = $event->getResponse();
    
    if ($this->reloadCache && null != $this->refererInfo) {
      $cookieGuest = array(
        'name'  => $this->sessionKey,
        'value' => $this->encode($this->refererInfo),
        'time'  => time() + 3600 * 24 * 7
      );

      $cookie = new Cookie($cookieGuest['name'], $cookieGuest['value'], $cookieGuest['time']);
      $response->headers->setCookie($cookie);
    }
  }
  
  public function encode($value){
    return base64_encode(json_encode($value));
  }
  
  public function decode($value){
    return json_decode(base64_decode($value));
  }

}