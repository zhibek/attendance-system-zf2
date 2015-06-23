<?php

/**
 * Description of VacationController
 *
 * @author ahmed
 */
class Myattendance_VacationController extends Zend_Controller_Action
{

    public function init()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $this->_em = $em;
    }

    public function indexAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $vacationModel = new Myattendance_Model_VacationRecord($em);
        $sickVacation = $vacationModel->listSickVacation();
        $this->view->sick = $sickVacation;

        $casualVacation = $vacationModel->listCasualVacation();
        $this->view->casual = $casualVacation;

        $annualVacation = $vacationModel->listAnnualVacation();
        $this->view->annual = $annualVacation;
    
        $sicks = $vacationModel->getSicksNumber();
        $this->view->sicks = $sicks;
    
        $casuals = $vacationModel->getCasualsNumber();
        $this->view->casuals = $casuals;
    
        $annuals = $vacationModel->getAnnualsNumber();
        $this->view->annuals = $annuals;
        
        $balance = $vacationModel->getVacationBalance();
        $this->view->balance = $balance;
    
    }

}
