<?php

/**
 * Description of VacationRecord
 *
 * @author ahmed
 */
class Myattendance_Model_VacationRecord
{

    //put your code here
    public function __construct($em)
    {
        $this->_em = $em;
        $vacationRepository = $this->_em->getRepository('Attendance\Entity\VacationRequest');
        $this->_repo = $vacationRepository;
    }

    public function listSickVacation()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $result = $this->_repo->findBy(array(
            'user' => $auth['id'],
            'vacationType' => 1,
        ));
        foreach ($result as $key) {
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

        return $result;
    }

    public function listCasualVacation()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $result = $this->_repo->findBy(array(
            'user' => $auth['id'],
            'vacationType' => 2,
        ));
        foreach ($result as $key) {
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
        return $result;
    }

    public function listAnnualVacation()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $result = $this->_repo->findBy(array(
            'user' => $auth['id'],
            'vacationType' => 3,
        ));
        foreach ($result as $key) {
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
        return $result;
    }

    public function getSicksNumber()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $query = $this->_em->createQuery('SELECT COUNT(u.id) FROM Attendance\Entity\VacationRequest u where u.user =?1 AND u.vacationType = 1');
        $query->setParameter(1, $auth['id']);
        $result = $query->execute();
        return $result[0]['1'];
    }

    public function getCasualsNumber()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $query = $this->_em->createQuery('SELECT COUNT(u.id) FROM Attendance\Entity\VacationRequest u where u.user =?1 AND u.vacationType = 2');
        $query->setParameter(1, $auth['id']);
        $result = $query->execute();
        return $result[0]['1'];
    }

    public function getAnnualsNumber()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $query = $this->_em->createQuery('SELECT COUNT(u.id) FROM Attendance\Entity\VacationRequest u where u.user =?1 AND u.vacationType = 3');
        $query->setParameter(1, $auth['id']);
        $result = $query->execute();
//        var_dump($result);exit();
        return $result[0]['1'];
    }

    public function getVacationBalance()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $query = $this->_em->createQuery('Select v FROM Attendance\Entity\User  v WHERE v.id = ?1');
        $query->setParameter(1, $auth['id']);
        $result = $query->execute();
        return $result[0]->vacationBalance;
    }

}
