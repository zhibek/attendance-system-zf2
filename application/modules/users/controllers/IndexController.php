<?php

class Users_IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {

        // get all databases entities
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $UserModel = new Users_Model_User($em);

        // know the desired page and get specified entities
        $UserModel->setPage($this->_getParam('page'));

        // know the number of pages
        $numberOfPages = $UserModel->getNumberOfPages();

        //create an array of page numbers
        if ($numberOfPages > 1) {
            $pageNumbers = range(1, $numberOfPages);
        } else {
            $pageNumbers = array();
        }

        //setting view varaiables
        $this->view->userList = $UserModel->getCurrentItems();
        $this->view->pageNumbers = $pageNumbers;
    }

    public function editAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $form = new Users_Form_User(array('em' => $em));
        
        $id = $this->getRequest()->getParam('id');
        $saveUser = new Users_Model_SaveUser($em);
        $userModel = $em->getRepository('Attendance\Entity\User');
        $userObj = $userModel->find($id);
        $saveUser->populateForm($userObj , $form);
        
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $data = $request->getParams();
            if(empty($data['password']))
            {
                $form->getElement("password")->setRequired(false);
                $form->getElement("confirmPassword")->setRequired(false);
            }
            if(empty($_FILES['photo']["name"]))
            {
                $form->getElement('photo')->setRequired(false);
            }
      
            if($form->isValid($request->getPost()))
            {   
                $saveUser->saveUser($request , $userObj);   
                $this->redirect("/users/index");
            }
            
        }
        
        $this->view->userForm = $form;
    }
    
    public function newAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $form = new Users_Form_User(array('em' => $em));

        $request = $this->getRequest();
        if ($request->isPost()) {
            // checking if the form is valid
            if ($form->isValid($request->getPost())) {
                $saveUserModel = new Users_Model_SaveUser($em);
                $saveUserModel->saveUser($request);
                $this->redirect("/users/index");
            }
            
        }
        $this->view->userForm = $form;
    }
    
    public function deleteAction()
    {
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $userModel = new Users_Model_SaveUser($em, $request);
        $userModel->deleteUser();
        $this->redirect("/users/index");
    }

}
