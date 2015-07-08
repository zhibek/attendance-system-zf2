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
        $this->resource = 'requests-myrequests';
        $storage = Zend_Auth::getInstance()->getIdentity();
        $this->role = $storage['rolename'];
    }

    public function indexAction()
    {
        $userRepository = $this->_em->getRepository('Attendance\Entity\User'); 
        
        $permissionModel = new Requests_Model_Permission($this->_em);

        $vacationRequestsModel = new Requests_Model_VacationRequest($this->_em);

        $workFromHomeModel = new Requests_Model_Workfromhome($this->_em);
        
        if($this->acl->isAllowed($this->role, $this->resource, 'viewall'))
        {
            $permissions = $permissionModel->listAll();
            $vacationRequests = $vacationRequestsModel->listAll();
            $workFromHomeRequests = $workFromHomeModel->listAll();
        } else {
            $permissions = $permissionModel->permissionListing();
            $vacationRequests = $vacationRequestsModel->vacationRequestListing();
            $workFromHomeRequests = $workFromHomeModel->workFromHomeListing();
        }


        $commentActionAllowed = $this->acl->isAllowed($this->role, $this->resource, 'comment');
        $cancelActionAllowed = $this->acl->isAllowed($this->role, $this->resource, 'cancel');
        $approveActionAllowed = $this->acl->isAllowed($this->role, $this->resource, 'approve');
        $declineActionAllowed = $this->acl->isAllowed($this->role, $this->resource, 'decline');
        foreach ($permissions as $request)
        {
            //$request->commentActionAllowed = $commentActionAllowed;
            $request->cancelActionAllowed = ($cancelActionAllowed && ($request->status == 'Submitted'));
            $request->approveActionAllowed = $approveActionAllowed && ($request->status == 'Submitted');
            $request->declineActionAllowed = $declineActionAllowed && ($request->status == 'Submitted');
        }
        
        foreach ($workFromHomeRequests as $request)
        {
            $request->user = $userRepository->find($request->user);
            $request->cancelActionAllowed = $cancelActionAllowed && ($request->status == 'Submitted');
            $request->approveActionAllowed = $approveActionAllowed && ($request->status == 'Submitted');
            $request->declineActionAllowed = $declineActionAllowed && ($request->status == 'Submitted');
        }
        
        foreach ($vacationRequests as $request)
        {
            //$request->commentActionAllowed = $commentActionAllowed;
            $request->cancelActionAllowed = $cancelActionAllowed && ($request->status == 'Submitted');
            $request->approveActionAllowed = $approveActionAllowed && ($request->status == 'Submitted');
            $request->declineActionAllowed = $declineActionAllowed && ($request->status == 'Submitted');
        }

        $this->view->permissions = $permissions;
        $this->view->vacationRequests = $vacationRequests;
        $this->view->workFromHomeRequests = $workFromHomeRequests;
    }

    public function cancelAction()
    {
        $requestId = $this->getParam('id');

        $request = $this->getRequestEntity($requestId);

        $request->status = Attendance\Entity\Permission::STATUS_CANCELLED;

        $this->updateEntity($request);
    }

    public function declineAction()
    {
        $requestId = $this->getParam('id');

        $request = $this->getRequestEntity($requestId);

        $request->status = Attendance\Entity\Permission::STATUS_DENIED;

        $this->updateEntity($request);
    }

    public function approveAction()
    {
        $requestId = $this->getParam('id');

        $request = $this->getRequestEntity($requestId);

        $request = $this->getRequestEntity($requestId);
        
        $previousRequestState = $request->status;
        
        $request->status = Attendance\Entity\Permission::STATUS_APPROVED;

        // affecting user's vacation balance
        $user = $request->user;
        
        switch ($this->getParam('requesttype')) {
            case "Permission" :
                break;
            case "VacationRequest" :
                if($request->vacationType->description == 'Casual' || $request->vacationType->description == 'Annual' )
                {
                    //to make sure its not approved twice
                    $vacationPeriod = $request->fromDate->diff($request->toDate);
                    if($previousRequestState == Attendance\Entity\Permission::STATUS_SUBMITTED)
                    {
                        $user->vacationBalance = $user->vacationBalance - ($vacationPeriod->days + 1);
                    }
                }
                break;
            case "Workfromhome" :
                break;
        }
        
//        $this->_em->merge($user);
//        $this->_em->flush();
//        
        $this->updateEntity($request);
        
        
    }

    private function getRequestEntity($requestId)
    {
        switch ($this->getParam('requesttype')) {
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
