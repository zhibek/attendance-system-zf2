<?php

/**
 * Description of Vacation
 *
 * @author ahmed
 */
class Requests_Model_Permission
{
    protected $repository;

    public function init()
    {
        // something  
    }

    public function __construct($em)
    {
        $this->entityManager = $em;
        $this->repository = $em->getRepository('Attendance\Entity\Permission');
        
    }

    public function newPermission($permissionInfo)
    {
        $entity = $this->createEntity($permissionInfo);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
    
    private function permissionListing()
    {
        $this->repository->findAll();
    }    

    private function createEntity($permissionInfo)
    {
        //get user id from session
        $userId = Zend_Auth::getInstance()->getIdentity('id');
       
        $userRepository = $this->entityManager->getRepository('Attendance\Entity\User');
        $entity = new Attendance\Entity\Permission();
        
        $entity->user = $userRepository->find($userId);
        $entity->date = new DateTime($permissionInfo['date']) ;
        $entity->fromTime =  new DateTime($permissionInfo['fromTime']) ;
        $entity->toTime =  new DateTime($permissionInfo['toTime']) ;
        $entity->dateOfSubmission=new DateTime("now");
        $entity->status=1;
        return $entity;
    }

}
