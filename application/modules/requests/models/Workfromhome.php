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
        $entity = new Attendance\Entity\WorkFromHome();
        $entity->startDate = new DateTime($requestInfo['startDate']);
        $entity->endDate = new DateTime($requestInfo['endDate']);
        $entity->reason = $requestInfo['reason'];
        $entity->user = Zend_Auth::getInstance()->getIdentity('id');
//      INSERT statements are not allowed in DQL, because entities and their
//      relations have to be introduced into the persistence context 
//      through EntityManager#persist() to ensure consistency of your object model.
        $this->_em->persist($entity);
        $this->_em->flush();
    }

}
