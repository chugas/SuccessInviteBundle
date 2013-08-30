<?php

namespace Success\InviteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InviteType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('emails', 'textarea')
    ;
  }

  public function getName() {
    return 'success_invite';
  }  
  
}
