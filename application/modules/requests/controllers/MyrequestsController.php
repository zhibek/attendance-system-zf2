<?php

/**
 * Description of PermissionController
 *
 * @author Ahmed
 */
class Requests_MyrequestsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $this->acl = Zend_Registry::get('acl');
    }

    public function indexAction()
    {
        $storage = Zend_Auth::getInstance()->getIdentity();
        $role = $storage['role'];
        $resource = 'requests-myrequests';
        // convert incomplete object into array
        $userRole = get_object_vars($role);
        $query = $this->_em->createQuery('Select v FROM Attendance\Entity\Role  v WHERE v.id = ?1');
        $query->setParameter(1, $userRole['id']);
        $result = $query->execute();
        $role = $result[0]->name;

        $permissionModel = new Requests_Model_Permission($this->_em);
        
        $vacationRequestsModel = new Requests_Model_VacationRequest($this->_em);
        
        $workFromHomeModel = new Requests_Model_Workfromhome($this->_em);
        
        
        if($this->acl->isAllowed($role, $resource, 'viewall'))
        {
            $permissions = $permissionModel->listAll();
            $vacationRequests = $vacationRequestsModel->listAll();
            $workFromHomeRequests = $workFromHomeModel->listAll();
        }
        else
        {
            $permissions = $permissionModel->permissionListing();
            $vacationRequests = $vacationRequestsModel->vacationRequestListing();
            $workFromHomeRequests = $workFromHomeModel->workFromHomeListing();
        }
        
        
        $commentActionAllowed = $this->acl->isAllowed($role, $resource, 'comment');
        $cancelActionAllowed = $this->acl->isAllowed($role, $resource, 'cancel');
        $approveActionAllowed = $this->acl->isAllowed($role, $resource, 'approve');
        $declineActionAllowed = $this->acl->isAllowed($role, $resource, 'decline');
        
        foreach ($permissions as $request)
        {
            $request->commentActionAllowed = $commentActionAllowed;
            $request->cancelActionAllowed = $cancelActionAllowed && ($request->status != 'Cancelled');
            $request->approveActionAllowed = $approveActionAllowed && ($request->status != 'Approved') && ($request->status != 'Cancelled');
            $request->declineActionAllowed = $declineActionAllowed && ($request->status != 'Denied') && ($request->status != 'Cancelled');
        }
        
        foreach ($workFromHomeRequests as $request)
        {
            $request->commentActionAllowed = $commentActionAllowed;
            $request->cancelActionAllowed = $cancelActionAllowed && ($request->status != 'Cancelled');
            $request->approveActionAllowed = $approveActionAllowed && ($request->status != 'Approved') && ($request->status != 'Cancelled');
            $request->declineActionAllowed = $declineActionAllowed && ($request->status != 'Denied') && ($request->status != 'Cancelled');
        }
        
        foreach ($vacationRequests as $request)
        {
            $request->commentActionAllowed = $commentActionAllowed;
            $request->cancelActionAllowed = $cancelActionAllowed && ($request->status != 'Cancelled');
            $request->approveActionAllowed = $approveActionAllowed && ($request->status != 'Approved') && ($request->status != 'Cancelled');
            $request->declineActionAllowed = $declineActionAllowed && ($request->status != 'Denied') && ($request->status != 'Cancelled');
        }
        
        $this->view->permissions = $permissions;
        $this->view->vacationRequests = $vacationRequests;
        $this->view->workFromHomeRequests = $workFromHomeRequests;

    }
    
    public function cancelAction()
    {
        $requestId = $this->getParam('id');
        
        $request = $this->getRequestEntity($requestId);
        
        $request->status = 2;

        $this->updateEntity($request);
    }
    
    public function declineAction()
    {
        $requestId = $this->getParam('id');
        
        $request = $this->getRequestEntity($requestId);
        
        $request->status = 4;

        $this->updateEntity($request);
    }
    
    public function approveAction()
    {
        $requestId = $this->getParam('id');
        
        $request = $this->getRequestEntity($requestId);
        
        $request = $this->getRequestEntity($requestId);
        
        $request->status = 3;

        $this->updateEntity($request);
    }
    
    private function getRequestEntity($requestId)
    {
        switch ($this->getParam('requesttype')) 
        {
            case "Permission" :
                $model = new Requests_Model_Permission($this->_em);
                break;
            case "VacationRequest" :
                $model = new Requests_Model_VacationRequest($this->_em);
                break;
            case "Workfromhome" :
                $model = new Requests_Model_Workfromhome($this->_em);
                break;
        }
        
        return $model->findById($requestId);
    }
    
    private function updateEntity($request)
    {
        
        $this->_em->merge($request);
        $this->_em->flush();
        
        $this->redirect('/requests/myrequests/index');
    }
    
    }
