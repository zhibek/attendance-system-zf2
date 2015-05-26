<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // Sample code for maniupulating Doctrine below...

        /*
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');

        $entity = new Attendance\Entity\User;
        $entity->name = 'TEST';
        $em->persist($entity);
        $em->flush();
        var_dump('CREATE', $entity);

        $repository = $em->getRepository('Attendance\Entity\User');
        $entities = $repository->findAll();
        var_dump('LIST', $entities);
        */
    }


}

