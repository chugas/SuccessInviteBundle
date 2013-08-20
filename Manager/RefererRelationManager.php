<?php

namespace Success\InviteBundle\Manager;

use Success\InviteBundle\Model\RefererInterface;
use Success\InviteBundle\Model\RefererRelationInterface;
use Success\InviteBundle\Event\RefererRelationEvent;
use Success\InviteBundle\Events;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;

class RefererRelationManager {

  protected $em;
  protected $class;
  protected $dispatcher;

  public function __construct(EntityManager $em, $class, EventDispatcherInterface $dispatcher) {
    $this->em = $em;
    $this->class = $class;
    $this->dispatcher = $dispatcher;
  }

  public function getRepository() {
    return $this->em->getRepository($this->class);
  }

  public function exists(UserInterface $refereable, RefererInterface $referer) {
    $relation = $this->getRefererRelation($refereable, $referer);

    return !is_null($relation);
  }

  public function create(UserInterface $refereable, RefererInterface $referer) {
    if ($this->exists($refereable, $referer)) {
      return true;
    }

    $class = $this->class;
    $relation = new $class();
    $relation->setRefereable($refereable);
    $relation->setReferer($referer);

    return $this->addRefererRelation($relation);
  }

  public function addRefererRelation(RefererRelationInterface $relation) {
    $event = new RefererRelationEvent($relation);
    $this->dispatcher->dispatch(Events::REFERER_RELATION_PRE_PERSIST, $event);

    $this->em->persist($relation);
    $this->em->flush();

    $this->dispatcher->dispatch(Events::REFERER_RELATION_POST_PERSIST, $event);

    return $relation;
  }
  
  public function getReferer(UserInterface $refereable){
    $q = $this->getRepository()
            ->createQueryBuilder('u')
            ->select('u', 'r')
            ->innerJoin('u.referer', 'r')
            ->where('u.refereable = :refereable');

    $q->setParameters(array(
        'refereable'  => $refereable
    ));

    $referer_relation = $q->getQuery()->getOneOrNullResult();
    if(!is_null($referer_relation)){
      return $referer_relation->getReferer();
    }
    return null;
  }
  
  public function getRefererRelation(UserInterface $refereable, RefererInterface $referer) {
    $q = $this->getRepository()
            ->createQueryBuilder('r')
            ->where('r.refereable = :refereable')
            ->andWhere('r.referer = :referer');

    $q->setParameters(array(
        'refereable'  => $refereable,
        'referer'     => $referer
    ));

    return $q->getQuery()->getOneOrNullResult();
  }
  
  public function getCountRefereables(RefererInterface $referer) {
    
  }

}