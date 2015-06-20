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
        $storage = $auth->getStorage();
        $userRepository = $this->_em->getRepository('Attendance\Entity\User');
        $vacationRepository = $this->_em->getRepository('Attendance\Entity\Vacation');
        $userId = $storage->read('id');
        $vacationType = $vacationRequestInfo['type'];
        $entity->user = $userRepository->find($userId);
        $entity->fromDate = new DateTime($vacationRequestInfo['fromDate']);
        $entity->toDate = new DateTime($vacationRequestInfo['toDate']);
        $entity->vacationType = $vacationRepository->find($vacationType);
        $entity->attachment = $this->saveAttachement();
        $entity->dateOfSubmission=new DateTime("now");
        $entity->status=1;
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    protected function saveAttachement()
    {
        $uploadResult = null;
        $upload = new Zend_File_Transfer_Adapter_Http();
        $upload->setOptions(array('ignoreNoFile' => true));
        $attachmentPath = APPLICATION_PATH . '/../public/upload/vacation_attachments/';
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
    
    
    public function getVacationById($id)
    {
        
        //$repository = $this->_em->getRepository('Attendance\Entity\VacationRequest');  
        //$requests = $repository->findBy(array('id' => $id ));
        $query = $this->_em->createQuery("SELECT v FROM Attendance\Entity\VacationRequest v WHERE v.id = $id");
        //$resutls = $query->getResult();
        $array = get_object_vars($query->getResult());
        //$test = get_object_vars($resutls);
        var_dump ($array);exit();
        return $result;
    }
    
    
    
    

}
