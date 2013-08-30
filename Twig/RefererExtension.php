<?php

namespace Success\InviteBundle\Twig;

use Symfony\Component\Routing\RouterInterface;

class RefererExtension extends \Twig_Extension {

  protected $router;
  protected $field;

  public function __construct(RouterInterface $router, $field) {
    $this->router = $router;
    $this->field = $field;
  }
  


  public function getName() {
    return 'referer';
  }
  
  public function getFunctions() {
    return array(
        'referer_url'  => new \Twig_Function_Method($this, 'getRefererUrl'),
    );
  }
  
  /**
   * Devuelve la url de referidos para el usuario $user
   * 
   * @param UserInterface $user
   * @return string
   */
  public function getRefererUrl($user){
    return $this->router->generate('homepage', array(), true) . '?' . $this->field . '=' . $user->getUsername();
  }

}
