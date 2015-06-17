<?php

class CamelCaseTech_Resource_Plugin_Auth extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(\Zend_Controller_Request_Abstract $request) {

        parent::preDispatch($request);
        $auth = Zend_Auth::getInstance();
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;

        // anonymous user can not move to any page but Sign/in 
        if (!$auth->hasIdentity() && $this->getRequest()->getControllerName() != 'sign') {
//            redirect to sign/in
            $this->getResponse()->setRedirect('/sign/in')->sendResponse();
        } else if ($auth->hasIdentity() && $this->getRequest()->getControllerName() == 'sign' &&
                $this->getRequest()->getActionName() == 'in') {

            $this->getResponse()->setRedirect('/index')->sendResponse();
        }

        if (!$auth->hasIdentity()) {
            $view->visible = FALSE;
        } else {
            $view->visible = TRUE;
        }
    }

}

class CamelCaseTech_Resource_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(\Zend_Controller_Request_Abstract $request) {
        parent::preDispatch($request);
        $auth = Zend_Auth::getInstance();
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;

        $acl = new Zend_Acl();
        // creating roles
        $base = new Zend_Acl_Role('base');
        $user = new Zend_Acl_Role('user');
        $hr = new Zend_Acl_Role('hr');
        $manager = new Zend_Acl_Role('manager');
        $admin = new Zend_Acl_Role('admin');
        // adding created roles to ACL
        $acl->addRole($base,null);
        $acl->addRole($user,$base);
        $acl->addRole($hr,$base);
        $acl->addRole($manager,$base);
        $acl->addRole($admin);
        $acl->allow($admin);
        // creating resources
        $acl->add(new Zend_Acl_Resource('requests-index'));
        // adding privileges
        
        $acl->allow('user', 'requests-index', array('index'));
        if($request->getControllerName() == 'error')  return ;
        
//        //start granting privileges 
        //$acl->allow('user', null, 'dsgsdgs');
        echo $acl->isAllowed('user', 'requests-'.($this->getRequest()->getControllerName()) ,$this->getRequest()->getActionName() ) ? "allowed" : "denied";
    }

}
