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
        $requestId = $request->id;
        $vacationRequestModel = new Requests_Model_VacationRequest($em);
        $vacation = $vacationRequestModel->getVacationById($requestId);
        $currentUserRole = $vacationRequestModel->getCurrentUserRole();
        
        if($currentUserRole == 1){
            $this->view->role = TRUE;
        }
        $this->view->vacationCreator = $vacation[0]->user;
        $this->view->vacationType = $vacation[0]->vacationType;
        $this->view->fromDate = $vacation[0]->fromDate;
        $this->view->toDate = $vacation[0]->toDate;
        $this->view->dateOfSubmission = $vacation[0]->dateOfSubmission;
        $this->view->attachment = $vacation[0]->attachment;
        $this->view->status = $vacation[0]->status;
        
    }
    
    

}
