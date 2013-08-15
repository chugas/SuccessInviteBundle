<?php

namespace Success\SuccessInviteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InviteController extends Controller {
  
  public function redirectAction($service) {
    switch ($service){
      case "facebook":
          // FACEBOOK
          $facebook = $this->get('bit_facebook.api');
          $contacts = $facebook->getFriends($facebook->getUser());        
        break;
      case "google":
          //GOOGLE
          $google = $this->get( 'bit_google.contact' );
          $contacts = $google->getContacts();
        break;
    }
    die();
  }

}
