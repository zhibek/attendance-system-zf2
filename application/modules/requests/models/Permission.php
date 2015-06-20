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

    public function permissionListing()
    {
        $storage = Zend_Auth::getInstance()->getIdentity();
        $data = $this->repository->findBy(array('user' => $storage['id']));
        foreach ($data as $key) {
            $key->dateOfSubmission = date_format($key->dateOfSubmission, 'm/d/Y');
            $key->fromTime = date_format($key->fromTime, 'H:i:s');
            $key->toTime = date_format($key->toTime, 'H:i:s');
            switch ($key->status) {
                case 1 :
                    $key->status = 'Submitted';
                    break;
                case 2 :
                    $key->status = 'Cancelled';
                    break;
                case 3 :
                    $key->status = 'Approved';
                    break;
                case 4 :
                    $key->status = 'Denied';
                    break;
            }
        }

        return $data;
    }

    private function createEntity($permissionInfo)
    {
        //get user id from session
        $userId = Zend_Auth::getInstance()->getIdentity('id');

        $userRepository = $this->entityManager->getRepository('Attendance\Entity\User');
        $entity = new Attendance\Entity\Permission();

        $entity->user = $userRepository->find($userId);
        $entity->date = new DateTime($permissionInfo['date']);
        $entity->fromTime = new DateTime($permissionInfo['fromTime']);
        $entity->toTime = new DateTime($permissionInfo['toTime']);
        $entity->dateOfSubmission = new DateTime("now");
        $entity->status = 1;
        return $entity;
    }

}
