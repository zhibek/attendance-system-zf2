<?php

class Users_IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {

        // get all databases entities
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $userRepository = $em->getRepository('Attendance\Entity\User');
        $UserModel = new Users_Model_User($em);
        $User = $UserModel->userStatus();
        $UserModel->setPage($this->_getParam('page'));
        // know the number of pages
        $numberOfPages = $UserModel->getNumberOfPages();
        //create an array of page numbers
        if ($numberOfPages > 1) {
            $pageNumbers = range(1, $numberOfPages);
        } else {
            $pageNumbers = array();
        }

        foreach ($UserModel->getCurrentItems() as $key) {
            if ($key->status == 'Active') {
                $key->active = TRUE;
            }
        }

        $this->view->userList = $UserModel->getCurrentItems();
        $this->view->pageNumbers = $pageNumbers;
    }

    public function editAction()
    {
        $em        = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $form      = new Users_Form_User(array('em' => $em));
        $id        = $this->getRequest()->getParam('id');
        $saveUser  = new Users_Model_SaveUser($em);
        $userModel = $em->getRepository('Attendance\Entity\User');
        $userObj   = $userModel->find($id);
        $photo     = $userObj->photo;
        $request   = $this->getRequest();
        $user      = array('username', 'password', "confirmPassword", 'name', 'mobile', 'dateOfBirth', 'startDate', 'description');
        $saveUser->populateForm($userObj, $form);
        if ($request->isPost()) {
            $data = $request->getParams();
            if (empty($data['password'])) {
                $form->getElement("password")->setRequired(false);
                $form->getElement("confirmPassword")->setRequired(false);
            }
            if (empty($_FILES['photo']["name"])) {
                $form->getElement('photo')->setRequired(false);
            }

            if ($form->isValid($request->getPost())) {
                $saveUser->saveUser($request, $userObj);
                $this->redirect("/users/index");
            } else {
                $mykey = array();
                $validElement = $form->getValidValues($request->getPost());
                foreach ($validElement as $key => $value) {
                    array_push($mykey, $key);
                }
                for ($j = 0; $j < count($user); $j++) {
                    if (!in_array($user[$j], $mykey)) {
                        $form->getElement($user[$j])->setAttribs(array('style' => 'border: 1px solid red'));
                    }
                }
            }
        }
        $this->view->photo    = $photo;
        $this->view->userForm = $form;
    }

    public function newAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $form = new Users_Form_User(array('em' => $em));
        $user = array('username', 'password', "confirmPassword", 'name', 'mobile', 'dateOfBirth', 'startDate', 'description');
        $request = $this->getRequest();
        if ($request->isPost()) {
            // checking if the form is valid
            if ($form->isValid($request->getPost())) {

                if ($request->getParam('password') == $request->getParam('confirmPassword')) {
                    $saveUserModel = new Users_Model_SaveUser($em);
                    $saveUserModel->saveUser($request);
                    $this->redirect("/users/index");
                } else {
                    $form->getElement('confirmPassword')->addError("password doesnt match");
                }
            } else {
                $mykey = array();
                $validElement = $form->getValidValues($request->getPost());
                foreach ($validElement as $key => $value) {
                    array_push($mykey, $key);
                }
                for ($j = 0; $j < count($user); $j++) {
                    if (!in_array($user[$j], $mykey)) {
                        $form->getElement($user[$j])->setAttribs(array('style' => 'border: 1px solid red'));
                    }
                }
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
