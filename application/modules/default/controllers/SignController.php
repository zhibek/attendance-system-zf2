<?php

class Default_SignController extends Zend_Controller_Action {

    public function init() {
        
    }
    public function index(){
        
    }

    public function inAction() {

        $form = new Default_Form_Signin();
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        //checking if we got a new post request
        if ($request->isPost()) {
            // checking if the form is valid
            if ($form->isValid($request->getPost())) {
                $auth = new Default_Model_UserAuth($request,$em);
                $result = $auth->authenticateMe();
                
                if($result){
                    $this->redirect('/index');
                }else{
                    $this->redirect('Sign/in');
                }
            }
        }
        
        $this->view->form = $form;
    }

    public function outAction() {
        Default_Service_Auth_Adapter::getInstance()->clearIdentity();
        //Redirect to login page again 
        $this->_helper->redirector('in');
    }

}
