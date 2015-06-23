<?php

class CamelCaseTech_Resource_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {

        parent::preDispatch($request);
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getIdentity();
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        // anonymous user can not move to any page but Sign/in 
        if (!$auth->hasIdentity() && $this->getRequest()->getControllerName() != 'sign') {
//            redirect to sign/in
            $this->getResponse()->setRedirect('/sign/in')->sendResponse();
        } else if ($auth->hasIdentity() && $this->getRequest()->getControllerName() == 'sign' &&
                $this->getRequest()->getActionName() == 'in') {

            $this->getResponse()->setRedirect('/index')->sendResponse();
        }

        if ($auth->hasIdentity() && $storage['rolename'] != "Admin" && $this->getRequest()->getModuleName() == 'users' &&
                $this->getRequest()->getControllerName() == 'index' && $this->getRequest()->getActionName() == 'index') {
            $this->getResponse()->setRedirect('error')->sendResponse();
        }

        if ($auth->hasIdentity() && $storage['rolename'] != "Admin" && $this->getRequest()->getModuleName() == 'settings') {
            $this->getResponse()->setRedirect('error')->sendResponse();
        }
        if( $auth->hasIdentity() && $storage['active'] == 0){
            $auth->clearIdentity();
            $this->getResponse()->setRedirect('/sign/out')->sendResponse();
        }

        if (!$auth->hasIdentity()) {
            $view->visible = FALSE;
        } else {
            $view->visible = TRUE;
            $storgae = Zend_Auth::getInstance()->getIdentity();
            $username = $storgae['name'];
            $view->name = $username;
        }
    }

}
