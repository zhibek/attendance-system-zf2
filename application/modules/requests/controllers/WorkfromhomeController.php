<?php

/**
 * Description of WorkFromHomeController
 *
 * @author Ahmed
 */
class Requests_WorkfromhomeController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $model = new Requests_Model_Workfromhome($em);
        $requests = $model->workFromHomeListing();
//        var_dump($requests);
    }

    public function newAction()
    {
        $form = new Requests_Form_WorkfromhomeForm();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $request = $this->getRequest();
        $requestInfo = $this->_request->getParams();
        $workFromHomeModel = new Requests_Model_Workfromhome($em);
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $workFromHomeModel->newRequest($requestInfo);
                $this->redirect('/requests/workfromhome/index');
            }
        }

        $this->view->newform = $form;
    }
    
    
    
    public function showAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $request = $this->getRequest();
        $requestId = $request->id;
        $workFromHomeRequestModel = new Requests_Model_Workfromhome($em);
        $workFromHome = $workFromHomeRequestModel->getWorkFromHomeById($requestId);
        $currentUserRole = $workFromHomeRequestModel->getCurrentUserRole();
        
        if($currentUserRole === 1){
            $this->view->role = TRUE;
        }
        $this->view->creator = $workFromHome[0]->user;
        $this->view->startDate = $workFromHome[0]->startDate;
        $this->view->endDate = $workFromHome[0]->endDate;
        $this->view->reason = $workFromHome[0]->reason;
        $this->view->dateOfSubmission = $workFromHome[0]->dateOfSubmission;
        $this->view->status = $workFromHome[0]->status;
        
        
        $commentForm = new Requests_Form_CommentForm();
        $commentModel = new Requests_Model_Comment($em);
        $request = $this->getRequest();
        $commentInfo =  $this->_request->getParams();
//        
//        if ($request->isPost()) {
//            if ($commentForm->isValid($request->getPost())) {
//                    $commentModel->addComment($commentInfo,$requestId);
//                }
//            }
//        $comments = $commentModel->listAllComments();
        $this->view->commentForm = $commentForm;
        
    }
    
    
    

}
