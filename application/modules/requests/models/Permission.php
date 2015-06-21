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

    public function listAll()
    {
        $data = $this->repository->findAll();
        return $this->prepareForDisplay($data);
    }

    public function findById($id)
    {
        return $this->repository->find($id);
    }

    public function permissionListing()
    {
        $storage = Zend_Auth::getInstance()->getIdentity();
        $data = $this->repository->findBy(array('user' => $storage['id']));
        return $this->prepareForDisplay($data);
    }

    private function createEntity($permissionInfo)
    {
        //get user id from session
        $storage = Zend_Auth::getInstance()->getIdentity();
        $userId = $storage['id'];

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

    private function prepareForDisplay($data)
    {
        foreach ($data as $key) {
            $key->dateOfSubmission = date_format($key->dateOfSubmission, 'm/d/Y');
            $key->fromTime = date_format($key->fromTime, 'H:i:s');
            $key->toTime = date_format($key->toTime, 'H:i:s');
            switch ($key->status) {
                case Attendance\Entity\Permission::STATUS_SUBMITTED :
                    $key->status = 'Submitted';
                    break;
                case Attendance\Entity\Permission::STATUS_CANCELLED :
                    $key->status = 'Cancelled';
                    break;
                case Attendance\Entity\Permission::STATUS_APPROVED :
                    $key->status = 'Approved';
                    break;
                case Attendance\Entity\Permission::STATUS_DENIED :
                    $key->status = 'Denied';
                    break;
            }
        }

        return $data;
    }

    public function getPermissionById($id)
    {
        $query = $this->entityManager->createQuery('Select p FROM Attendance\Entity\Permission  p WHERE p.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        foreach ($result as $key) {
            $key->dateOfSubmission = date_format($key->dateOfSubmission, 'm/d/Y');
            $key->date = date_format($key->date, 'm/d/Y');
            $key->fromTime = date_format($key->fromTime, 'm:s');
            $key->toTime = date_format($key->toTime, 'm:s');
            $key->user = $this->getUserNameById($key->user);
            if ($key->status == 1) {
                $key->status = "ON";
            } else {
                $key->status = "OFF";
            }
        }
        return $result;
    }

    function getUserNameById($id)
    {
        $query = $this->entityManager->createQuery('Select u FROM Attendance\Entity\User  u WHERE u.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        return $result[0]->name;
    }

    function getCurrentUserRole()
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $id = $storage->read('id');
        $query = $this->entityManager->createQuery('Select u FROM Attendance\Entity\User  u WHERE u.id = ?1');
        $query->setParameter(1, $id['id']);
        $result = $query->execute();
        return $result[0]->role;
    }

}
