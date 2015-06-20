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
    
    public function createAction()
    {
        
        $form = new Requests_Form_VacationRequestForm();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $request = $this->getRequest();
        $vacationRequestInfo =  $this->_request->getParams();
        $vacationModel = new Requests_Model_VacationRequest($em);
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                    $vacationModel->newVacationRequest($vacationRequestInfo);
                    $this->redirect('/requests/vacation/index');
                }
            }
        
        
        
        
        
        $this->view->vacationRequestForm = $form;
    }
    
    
    
    public function showAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $request = $this->getRequest();
        $requestId =  $request->id;
        $vacationRequestModel = new Requests_Model_VacationRequest($em);
        
        $vacation = $vacationRequestModel->getVacationById($requestId);
       
        $this->view->vacationArray = $vacation[0];
        $this->view->id = $request->id;
    }
    
    

}
