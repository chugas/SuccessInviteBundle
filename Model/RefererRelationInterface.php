<?php

namespace Success\InviteBundle\Model;

/**
 * RefererRelation inteface.
 *
 * @author Gaston Caldeiro <chugas488@gmail.com>
 */
interface RefererRelationInterface {

  public function getRefereable();
  
  public function setRefereable($refereable = null);
  
  public function getReferer();
  
  public function setReferer($referer = null);
  
}
