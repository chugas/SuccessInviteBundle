<?php

namespace Success\InviteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InviteController extends Controller {
  
  public function showAction() {
    return $this->render('SuccessInviteBundle:Invite:show.html.twig', array());
  }  
  
  public function redirectAction($service) {
    $contacts = array();
    
    try {
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
    }catch(Exception $e) {
      // Loguear Error
    }

    return $this->render('SuccessInviteBundle:Invite:list.html.twig', array('contacts' => $contacts));
  }
  
  /**
   * Procesa la lista de envio
   * 
   */
  public function processAction() {
    
  }
  
  /**
   * Procesa el formulario de envio manual de invitaciones
   */
  public function processFormAction(){
    
  }

  /**
   * Envia los emails de invitaciones a los usuarios.
   * 
   * @param Array $contacts Coleccion de emails que recibiran la invitacion
   */
  public function sendInvitations($contacts) {
    
  } 
  


}
