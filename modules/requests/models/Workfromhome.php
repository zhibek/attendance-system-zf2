<?php

/**
 * Description of Workfromhome
 *
 * @author ahmed
 */
class Requests_Model_Workfromhome
{

    public function __construct($em, $request = null)
    {
        $this->_em = $em;
        $this->_request = $request;
    }

    public function newRequest($requestInfo)
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $entity = new Attendance\Entity\WorkFromHome();
        $entity->startDate = new DateTime($requestInfo['startDate']);
        if ($requestInfo['endDate'] != NULL) {
            $entity->endDate = new DateTime($requestInfo['endDate']);
        } else {
            $entity->endDate = NULL;
        }
        $entity->reason = $requestInfo['reason'];
        $entity->user = $auth['id'];
        $entity->dateOfSubmission = new DateTime("now");
        $entity->status = 1;
//      INSERT statements are not allowed in DQL, because entities and their
//      relations have to be introduced into the persistence context 
//      through EntityManager#persist() to ensure consistency of your object model.
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function listAll()
    {
        $repository = $this->_em->getRepository('Attendance\Entity\WorkFromHome');
        $data = $repository->findAll();
        return $this->prepareForDisplay($data);
    }

    public function findById($id)
    {
        $repository = $this->_em->getRepository('Attendance\Entity\WorkFromHome');
        return $repository->find($id);
    }

    public function workFromHomeListing()
    {
        $repository = $this->_em->getRepository('Attendance\Entity\WorkFromHome');
        $storage = Zend_Auth::getInstance()->getIdentity();
        $requests = $repository->findBy(array(
            'user' => $storage['id']
        ));

        foreach ($requests as $key) {
            $key->dateOfSubmission = date_format($key->dateOfSubmission, 'm/d/Y');
            $key->startDate = date_format($key->startDate, 'm/d/Y');
            $key->endDate = date_format($key->endDate, 'm/d/Y');
            switch ($key->status) {
                case Attendance\Entity\WorkFromHome::STATUS_SUBMITTED :
                    $key->status = 'Submitted';
                    break;
                case Attendance\Entity\WorkFromHome::STATUS_CANCELLED :
                    $key->status = 'Cancelled';
                    break;
                case Attendance\Entity\WorkFromHome::STATUS_APPROVED :
                    $key->status = 'Approved';
                    break;
                case Attendance\Entity\WorkFromHome::STATUS_DENIED :
                    $key->status = 'Denied';
                    break;
            }
        }
        return $requests;
    }

    private function prepareForDisplay($data)
    {
        foreach ($data as $key) {
            $key->dateOfSubmission = date_format($key->dateOfSubmission, 'm/d/Y');
            $key->startDate = date_format($key->startDate, 'm/d/Y');
            if (!$key->endDate) {
                $key->endDate = NULL;
            } else {
                $key->endDate = date_format($key->endDate, 'm/d/Y');
            }
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

    public function getWorkFromHomeById($id)
    {
        $query = $this->_em->createQuery('Select w FROM Attendance\Entity\WorkFromHome  w WHERE w.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        foreach ($result as $key) {
            $key->dateOfSubmission = date_format($key->dateOfSubmission, 'm/d/Y');
            $key->startDate = date_format($key->startDate, 'm/d/Y');
            $key->endDate = date_format($key->endDate, 'm/d/Y');
            $key->user = $this->getUserNameById($key->user);
            if ($key->status == 1) {
                $key->status = "Submitted";
            } elseif ($key->status == 2) {
                $key->status = "Cancelled";
            } elseif ($key->status == 3) {
                $key->status = "Approved";
            } elseif ($key->status == 4) {
                $key->status = "Denied";
            }
        }
        return $result;
    }

    function getUserNameById($id)
    {
        $query = $this->_em->createQuery('Select u FROM Attendance\Entity\User  u WHERE u.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        return $result[0]->name;
    }

    function getCurrentUserRole()
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $id = $storage->read('id');
        $query = $this->_em->createQuery('Select u FROM Attendance\Entity\User  u WHERE u.id = ?1');
        $query->setParameter(1, $id['id']);
        $result = $query->execute();
        return $result[0]->role;
    }

    function getCurrentUserId()
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $id = $storage->read('id');
        return $id['id'];
    }

}
