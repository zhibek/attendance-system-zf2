<?php

      
        
 class Users_DataGeneratorController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $loader = new \Nelmio\Alice\Fixtures\Loader();
        
        
        $objects = $loader->load('Attendance/Fixtures/fixtures.yml');
        
        
        foreach($objects as $object)
        {
            $object->dateOfBirth = new \DateTime("now");
            $object->startDate = new \DateTime("now");
            
            $em->persist($object);
        }
        
        $em->flush();
        
        echo '<h1>Data Added</h1>';
        die;
    }

}
