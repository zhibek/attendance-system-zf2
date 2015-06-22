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

}
