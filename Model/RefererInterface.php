<?php

namespace Success\InviteBundle\Model;

/**
 * Referer inteface.
 *
 * @author Gaston Caldeiro <chugas488@gmail.com>
 */
interface RefererInterface {

  /**
   * Get ID.
   *
   * @return integer
   */
  public function getId();

  public function getSlug();

}
