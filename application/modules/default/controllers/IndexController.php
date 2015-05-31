e<?php

class Default_IndexController extends Zend_Controller_Action {

    public function init() {
        $authorization = Default_Service_Auth_Adapter::getInstance();
        if (!$authorization->hasIdentity() ){
            $this->redirect("Sign/in");
            $this->view->visible=FALSE;
            
        }
        $Identity= $authorization->getIdentity();
        echo "identity is :".$Identity;
        $this->view->visible=TRUE ;
        
    }


    public function indexAction() {

        }
}
