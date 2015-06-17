<?php

class CamelCaseTech_Resource_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {

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

class CamelCaseTech_Resource_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {
        parent::preDispatch($request);
        $auth = Zend_Auth::getInstance();
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        
        $acl = new Zend_Acl();
        $roleGuest = new Zend_Acl_Role('guest');
        $acl->addRole($roleGuest);
        $acl->deny($roleGuest);
        $acl->allow($roleGuest, null, 'new');
        echo $acl->isAllowed('guest', null, $this->getRequest()->getActionName() ) ? "allowed" : "denied";
    }
}
