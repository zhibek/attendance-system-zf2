<?php

/**
 * Description of PermissionController
 *
 * @author Moataz
 */
class Requests_PermissionController extends Zend_Controller_Action
{
    public function init() {
        $this->entityManager = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $this->permissionModel = new Requests_Model_Permission($this->entityManager);
    }

    public function indexAction()
    {
        
    }
    
    public function newAction()
    {
        $form = new Requests_Form_PermissionForm(null,$this->entityManager);
        
        $request = $this->getRequest();
        
        if ($request->isPost()) 
        {
            if ($form->isValid($request->getPost())) 
            {
                $permissionInfo = $this->_request->getParams();
                $this->permissionModel->newPermission($permissionInfo);
                $this->redirect('/requests/permission/index');
            }
        }

        $this->view->form = $form;
    }
    
    
    
    public function showAction()
    {
        
    }
    
    

}
