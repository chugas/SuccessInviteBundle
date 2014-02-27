<?php

namespace Success\InviteBundle\Controller;

use Success\InviteBundle\Form\InviteType;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\All;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InviteController extends Controller {
  
  public function showAction() {
    $form = $this->createForm(new InviteType());
    return $this->render('SuccessInviteBundle:Invite:show.html.twig', array('form' => $form->createView()));
  }  
  
  public function redirectAction($service) {
    $contacts = array();
    $form = $this->createForm(new InviteType());

    try {
      switch ($service){
        case "facebook":
            // FACEBOOK
            $facebook = $this->get('bit_facebook.api');
            $info = $facebook->getFriends($facebook->getUser());
            foreach($info as $data){
              $contacts['name'] = $data['first_name'] . ' ' . $data['last_name'];
              $contacts['email'] = $data['email'];
            }
          break;
        case "google":
            //GOOGLE
            $google = $this->get( 'bit_google.contact' );
            $contacts = $google->getContacts();
          break;
      }
    }catch(\Exception $e) {
      return $this->redirect($this->generateUrl('user_step_third'));
    }

    return $this->render('SuccessInviteBundle:Invite:show.html.twig', array('form' => $form->createView(), 'contacts' => $contacts));
  }
  
  /**
   * Procesa la lista de envio
   * 
   */
  public function processAction(Request $request) {
    // Obtengo emails
    $emails = $request->get('emails');
    
    $response = $this->process($emails);

    if ($request->isXmlHttpRequest()) {

      return new Response(json_encode($response), 200, array('Content-Type'=>'application/json'));

    }else {
      
      if(!$response['response']){
        $this->setFlash('error', 'Se han encontrado algunos errores. Recuerda que debes ingresar los emails separados por coma: ' . implode(',', $response['emails']));
      } else {
        $this->setFlash('success', 'Se han enviado los emails correctamente.');        
      }

      $form = $this->createForm(new InviteType());
      return $this->render('SuccessInviteBundle:Invite:show.html.twig', array('form' => $form->createView()));
      
    }
  }
  
  /**
   * Procesa el formulario de envio manual de invitaciones
   */
  public function processFormAction(Request $request){
    $form = $this->createForm(new InviteType());
    $form->bind($request);

    $data = $form->getData();
    $emails = $this->transform($data['emails']);

    $response = $this->process($emails);

    if ($request->isXmlHttpRequest()) {

      return new Response(json_encode($response), 200, array('Content-Type'=>'application/json'));

    }else {

      if(!$response['response']){
        $this->setFlash('error', 'Se han encontrado algunos errores. Recuerda que debes ingresar los emails separados por coma: ' . implode(',', $response['emails']));
      }else {
        $this->setFlash('success', 'Se han enviado los emails correctamente.');        
      }

      return $this->render('SuccessInviteBundle:Invite:show.html.twig', array('form' => $form->createView()));

    }
  }
  
  protected function process($emails) {
    $all = new All(array(new Email()));
    $errorList = $this->get('validator')->validateValue($emails, $all);

    if (count($errorList) == 0) {

      $this->sendInvitations($emails);
      $response = array('response' => true);

    } else {

      $badEmails = array();
      foreach ($errorList as $error) {
        $badEmails[] = $error->getInvalidValue();
      }

      $response = array('response' => false, 'emails' => $badEmails);
    }
    
    return $response;
  }

  /**
   * Envia los emails de invitaciones a los usuarios.
   * 
   * @param Array $contacts Coleccion de emails que recibiran la invitacion
   */
  protected function sendInvitations($contacts) {
    
    $message = \Swift_Message::newInstance()
        ->setSubject('Agrotemario')
        ->setFrom('soporte@agrotemario.com')
        ->setContentType('text/html')            
        ->setBody($this->renderView('SuccessInviteBundle:Invite:mail.html.twig', array('userFrom' => $this->getUser())))
    ;

    foreach($contacts as $contact) {
      $message->setTo($contact);
      $this->get('swiftmailer.mailer.queue')->send($message);
    }
 
  }
  
  protected function transform($string){
    return explode(',', str_replace(' ', '', $string));
  }
  
  protected function setFlash($type, $message) {
    return $this
              ->get('session')
              ->getFlashBag()
              ->add($type, $message)
    ;
  }
  
  /*protected function generateFlashMessage($event) {
    $message = 'invite.' . $event;
    
    return $this->get('translator')->trans($message, array('%resource%' => 'flashes'), 'flashes');    
  }*/

}
