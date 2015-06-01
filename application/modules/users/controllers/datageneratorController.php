<?php

      
        
 class Users_DataGeneratorController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $loader = new \Nelmio\Alice\Fixtures\Loader();
        
        
        $objects = $loader->load('Attendance/Fixtures/UserFixtures.yml');
//        $objects = $loader->load('Attendance/Fixtures/BranchFixtures.yml');
//        $objects = $loader->load('Attendance/Fixtures/PositionFixtures.yml');
//        $objects = $loader->load('Attendance/Fixtures/DepartmentFixtures.yml');
        
        
        var_dump($objects);die;
        
        foreach($objects as $object)
        {
            $object->dateOfBirth = new \DateTime("now");
            $object->startDate = new \DateTime("now");
            
            $em->persist($object);
        }
        
        $em->flush();
        
        echo 'Data Added';
        die;
    }

}
