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
            if($key->toDate == Null){
                $key->toDate = Null;
            }
            else{
                $key->toDate = date_format($key->toDate, 'm/d/Y');
            }
            
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
//        var_dump($result[0]->fromDate  , $result[1]->fromDate) ;die;
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
        $result = $this->_repo->findBy(array(
            'user' => $auth['id'],
            'vacationType' => 1,
            'status' => 3
        ));
        $startArray = array();
        $endArray = array();
        foreach ($result as $key) {
            array_push($startArray, $key->fromDate);
            array_push($endArray, $key->toDate);
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
        $sum = 0;
        for ($index = 0; $index < count($startArray); $index++) {
            $startTemp = explode('/', $startArray[$index]);
            $endTemp = explode('/', $endArray[$index]);
            $sum = ($endTemp[1] - $startTemp[1] + 1) + $sum;
        }
        return $sum;
    }

    public function getCasualsNumber()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $result = $this->_repo->findBy(array(
            'user' => $auth['id'],
            'vacationType' => 2,
            'status' => 3
        ));
        $startArray = array();
        $endArray = array();
        foreach ($result as $key) {
            array_push($startArray, $key->fromDate);
            array_push($endArray, $key->toDate);
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
        $sum = 0;
        for ($index = 0; $index < count($startArray); $index++) {
            $startTemp = explode('/', $startArray[$index]);
            $endTemp = explode('/', $endArray[$index]);
            $sum = ($endTemp[1] - $startTemp[1] + 1) + $sum;
        }
        return $sum;
    }

    public function getAnnualsNumber()
    {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $result = $this->_repo->findBy(array(
            'user' => $auth['id'],
            'vacationType' => 3,
            'status' => 3
        ));
        $startArray = array();
        $endArray = array();
        foreach ($result as $key) {
            array_push($startArray, $key->fromDate);
            array_push($endArray, $key->toDate);
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
        $sum = 0;
        for ($index = 0; $index < count($startArray); $index++) {
            $startTemp = explode('/', $startArray[$index]);
            $endTemp = explode('/', $endArray[$index]);
            $sum = ($endTemp[1] - $startTemp[1] + 1) + $sum;
        }
        return $sum;
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
