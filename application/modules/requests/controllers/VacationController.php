<?php

/**
 * Description of VacationController
 *
 * @author Mohamed Ramadan
 */
class Requests_VacationController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
    }
    
    public function newAction()
    {
        
        $from = new Requests_Form_VacationRequestForm();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $request = $this->getRequest();
        $vacationRequestInfo =  $this->_request->getParams();
        $vacationModel = new Requests_Model_VacationRequest($em);
        $vacationModel->newVacationRequest($vacationRequestInfo);
        $this->view->vacationRequestForm = $from;
    }

}
