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
        if($this->acl->isAllowed($role, $resource, 'viewall'))
        {
            $permissions = $permissionModel->listAll();
        }
        else
        {
            $permissions = $permissionModel->permissionListing();
        }
        
        $commentActionAllowed = $this->acl->isAllowed($role, $resource, 'comment');
        $cancelActionAllowed = $this->acl->isAllowed($role, $resource, 'cancel');
        $approveActionAllowed = $this->acl->isAllowed($role, $resource, 'approve');
        $declineActionAllowed = $this->acl->isAllowed($role, $resource, 'decline');

        foreach ($permissions as $permission)
        {
            $permission->commentActionAllowed = $commentActionAllowed;
            $permission->cancelActionAllowed = $cancelActionAllowed;
            $permission->approveActionAllowed = $approveActionAllowed;
            $permission->declineActionAllowed = $declineActionAllowed;
        }
        
        $this->view->permissions = $permissions;

        $vacationRequestsModel = new Requests_Model_VacationRequest($this->_em);
        $vacationRequests = $vacationRequestsModel->vacationRequestListing();
        $this->view->vacationRequests = $vacationRequests;

        $workFromHomeModel = new Requests_Model_Workfromhome($this->_em);
        $workFromHomeRequests = $workFromHomeModel->workFromHomeListing();
        $this->view->workFromHomeRequests = $workFromHomeRequests;

    }
    
    }
