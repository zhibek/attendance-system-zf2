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
        $entity->dateOfSubmission = new DateTime("now");
        $entity->status = 1;
//      INSERT statements are not allowed in DQL, because entities and their
//      relations have to be introduced into the persistence context 
//      through EntityManager#persist() to ensure consistency of your object model.
        $this->_em->persist($entity);
        $this->_em->flush();
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

}
