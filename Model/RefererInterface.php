<?php

namespace Success\InviteBundle\Model;

/**
 * Relation inteface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface RefererInterface
{
    /**
     * Get ID.
     *
     * @return integer
     */
    public function getId();

    /**
     * Set entity object1 value.
     *
     * @param string $entity Object value
     */
    public function setEntity1($entity);

    /**
     * Get entity object1 value.
     *
     * @return string
     */
    public function getEntity1();

    /**
     * Set entity object2 value.
     *
     * @param string $entity Object value
     */
    public function setEntity2($entity);

    /**
     * Get entity object2 value.
     *
     * @return string
     */
    public function getEntity2();

}
