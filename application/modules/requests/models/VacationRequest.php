<?php

/**
 * Description of VacationRequests
 * @author Mohamed Ramadan
 */
class Requests_Model_VacationRequest
{

    public function init()
    {
        // something  
    }

    public function __construct($em, $request = null)
    {
        $this->_em = $em;
        $this->_request = $request;
    }

    public function newVacationRequest($vacationRequestInfo)
    {
        $entity = new Attendance\Entity\VacationRequest();
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getIdentity();
        $userRepository = $this->_em->getRepository('Attendance\Entity\User');
        $vacationRepository = $this->_em->getRepository('Attendance\Entity\Vacation');
        $userId = $storage['id'];
        $vacationType = $vacationRequestInfo['type'];
        $entity->user = $userRepository->find($userId);
        $entity->fromDate = new DateTime($vacationRequestInfo['fromDate']);
        $entity->toDate = new DateTime($vacationRequestInfo['toDate']);
        $entity->vacationType = $vacationRepository->find($vacationType);
        $entity->attachment = $this->saveAttachement();
        $entity->dateOfSubmission = new DateTime("now");
        $entity->status = 1;
        $this->_em->persist($entity);
        $this->_em->flush($entity);
    }

    protected function saveAttachement()
    {
        $uploadResult = null;
        $upload = new Zend_File_Transfer_Adapter_Http();
        $upload->setOptions(array('ignoreNoFile' => true));
        $attachmentPath = APPLICATION_PATH . '/../public/upload/vacation_attachments/';
        if (!file_exists($attachmentPath)) {
            mkdir($attachmentPath, 0777);
        }
        $upload->setDestination($attachmentPath);
        try {
            $upload->receive();
        } catch (Zend_File_Transfer_Exception $e) {
            $uploadResult = 'null';
        }
        $name = $upload->getFileName('attachment');
        if ($name) {
            $extention = pathinfo($name, PATHINFO_EXTENSION);
            $newName = $this->getRandomName();
            rename($name, APPLICATION_PATH . '/../public/upload/vacation_attachments/' . $newName . '.' . $extention);
            $uploadResult = '/upload/vacation_attachments/' . $newName . '.' . $extention;
        } else {
            $uploadResult = null;
        }
        return $uploadResult;
    }

    protected function getRandomName()
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789');
        shuffle($seed);
        $cid = substr(implode('', $seed), 1, 10) . uniqid();
        return $cid;
    }

    public function listAll()
    {
        $repository = $this->_em->getRepository('Attendance\Entity\VacationRequest');
        $data = $repository->findAll();
        return $this->prepareForDisplay($data);
    }

    public function findById($id)
    {
        $repository = $this->_em->getRepository('Attendance\Entity\VacationRequest');
        return $repository->find($id);
    }

    // Dont Delete
    public function vacationRequestListing()
    {
        $repository = $this->_em->getRepository('Attendance\Entity\VacationRequest');
        $storage = Zend_Auth::getInstance()->getIdentity();
        $requests = $repository->findBy(array('user' => $storage['id']));
        foreach ($requests as $key) {
            $key->dateOfSubmission = date_format($key->dateOfSubmission, 'm/d/Y');
            $key->fromDate = date_format($key->fromDate, 'm/d/Y');
            $key->toDate = date_format($key->toDate, 'm/d/Y');
            switch ($key->status) {
                case Attendance\Entity\VacationRequest::STATUS_SUBMITTED :
                    $key->status = 'Submitted';
                    break;
                case Attendance\Entity\VacationRequest::STATUS_CANCELLED :
                    $key->status = 'Cancelled';
                    break;
                case Attendance\Entity\VacationRequest::STATUS_APPROVED :
                    $key->status = 'Approved';
                    break;
                case Attendance\Entity\VacationRequest::STATUS_DENIED :
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
            $key->fromDate = date_format($key->fromDate, 'm/d/Y');
            $key->toDate = date_format($key->toDate, 'm/d/Y');
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

    public function getVacationById($id)
    {
        $query = $this->_em->createQuery('Select v FROM Attendance\Entity\VacationRequest  v WHERE v.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        foreach ($result as $key) {
            $key->dateOfSubmission = date_format($key->dateOfSubmission, 'm/d/Y');
            $key->fromDate = date_format($key->fromDate, 'm/d/Y');
            $key->toDate = date_format($key->toDate, 'm/d/Y');
            $key->user = $this->getUserNameById($key->user);
            $key->vacationType = $this->getVacationTypeById($key->vacationType);
            if ($key->status == 1) {
                $key->status = "ON";
            } else {
                $key->status = "OFF";
            }
            if ($key->attachment == NULL) {
                $key->attachment = "No Attachment Available";
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

    function getVacationTypeById($id)
    {
        $query = $this->_em->createQuery('Select v FROM Attendance\Entity\Vacation  v WHERE v.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->execute();
        return $result[0]->type;
    }

    function getCurrentUserId()
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $id = $storage->read('id');
        return $id['id'];
    }

}
