<?php

class Default_SignController extends Zend_Controller_Action
{

    protected $_flashMessenger = null;

    public function init()
    {
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->initView();
        $this->_flashMessenger->addMessage('Username and password are invalid !');
    }

    public function index()
    {
        //something
    }

    public function inAction()
    {

        $form = new Default_Form_Signin();
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        //checking if we got a new post request
        if ($request->isPost()) {
            // checking if the form is valid
            if ($form->isValid($request->getPost())) {
                $auth = new Default_Model_UserAuth($request, $em);
                $result = $auth->authenticateMe();

                if ($result->isValid()) {
                    $auth->newSession();
                    $this->redirect('/index');
                } else {

                    $messages = array();
                    foreach($this->_flashMessenger->getMessages() as $m){
                        $messages['message'] = $m;
                    }
                    
                    $this->view->messages = $messages;
//                    $this->inAction();
//                    $this->render();
//                    $this->redirect('sign/in');
                }
            }
        }

        $this->view->form = $form;
    }

    public function outAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        //Redirect to login page again 
        $this->redirect('/in');
    }

}
