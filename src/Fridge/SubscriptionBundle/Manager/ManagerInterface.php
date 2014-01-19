<?php

namespace Fridge\SubscriptionBundle\Manager;

/**
 * Interface ManagerInterface
 * @package Fridge\SubscriptionBundle\Manager
 */
interface ManagerInterface
{
    /**
     * @param  null  $constructWith
     * @return mixed
     */
    public function create($constructWith = null);

    /**
     * @param $entity
     * @param  bool  $flush
     * @return mixed
     */
    public function save($entity, $flush = true);

    /**
     * @param $entity
     * @param  bool  $flush
     * @return mixed
     */
    public function remove($entity, $flush = true);

}
