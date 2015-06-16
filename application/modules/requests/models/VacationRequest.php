<?php

/**
 * Description of VacationRequests
 * @author mohamed
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
        $auth=  Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $userRepository = $this->_em->getRepository('Attendance\Entity\User');
        $vacationRepository = $this->_em->getRepository('Attendance\Entity\Vacation');
        $userId = $storage->read('id');
        $vacationType = $vacationRequestInfo['type'];
        $entity->user = $userRepository->find($userId);
        $entity->fromDate = new DateTime($vacationRequestInfo['fromDate']);
        $entity->toDate = new DateTime($vacationRequestInfo['toDate']);
        $entity->vacationType =$vacationRepository->find($vacationType);
        
        if(isset($vacationRequestInfo['attachment'])){
            $entity->attachment = $this->savePhoto();
        }
        
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    
    
    protected function savePhoto()
    {
        $uploadResult = null;
        
        $upload = new Zend_File_Transfer_Adapter_Http();

        $imagesPath = APPLICATION_PATH . '/../public/upload/images/';

        $upload->setDestination($imagesPath);
        
        try {
            // upload received file(s)
            $upload->receive();
            
        } catch (Zend_File_Transfer_Exception $e) {
            $uploadResult = '/upload/images/defaultpic.png';
        }

        $name = $upload->getFileName('attachment');
        
        $extention = pathinfo($name, PATHINFO_EXTENSION);

        //get random new namez
        $newName = $this->getRandomName();

        rename($name, APPLICATION_PATH . '/../public/upload/images/' . $newName . '.' . $extention);

        $uploadResult = '/upload/images/' . $newName . '.' . $extention;
        return $uploadResult;
    }

    protected function getRandomName()
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $cid = substr(implode('', $seed), 1, 10) . uniqid();


        return $cid;
    }
    
    


}

