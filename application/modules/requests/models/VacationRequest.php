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
        $storage=$auth->getStorage();
        $id = $storage->read('id');
        //$entity->user = $id ;
        //$entity->fromDate = $vacationRequestInfo['fromDate'];
        //$entity->toDate = $vacationRequestInfo['toDate'];
        //$entity->vacationType = $vacationRequestInfo['type'];
        //$this->_em->persist($entity);
        //$this->_em->flush();
    }



}

