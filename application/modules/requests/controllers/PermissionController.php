<?php

/**
 * Description of PermissionController
 *
 * @author Moataz
 */
class Requests_PermissionController extends Zend_Controller_Action
{

    public function init()
    {
        $this->entityManager = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $this->permissionModel = new Requests_Model_Permission($this->entityManager);
    }

    public function indexAction()
    {
        
    }

    public function newAction()
    {
        $form = new Requests_Form_PermissionForm(null, $this->entityManager);

        $request = $this->getRequest();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $permissionInfo = $this->_request->getParams();
                $this->permissionModel->newPermission($permissionInfo);
                $this->redirect('/requests/permission/index');
            }
        }

        $this->view->form = $form;
    }

    public function showAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $request = $this->getRequest();
        $requestId = $request->id;
        $permissionRequestModel = new Requests_Model_Permission($em);
        $permission = $permissionRequestModel->getPermissionById($requestId);
        $currentUserRole = $permissionRequestModel->getCurrentUserRole();

        if ($currentUserRole === 1) {
            $this->view->role = TRUE;
        }
        $this->view->permissionCreator = $permission[0]->user;
        $this->view->permissionDate = $permission[0]->date;
        $this->view->fromTime = $permission[0]->fromTime;
        $this->view->toTime = $permission[0]->toTime;
        $this->view->dateOfSubmission = $permission[0]->dateOfSubmission;
        $this->view->status = $permission[0]->status;

        $commentForm = new Requests_Form_CommentForm();
        $commentModel = new Requests_Model_Comment($em);
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            if ($commentForm->isValid($request->getPost())) {
                $commentInfo = $this->_request->getParams();
                $commentModel->addComment($commentInfo, $requestId,$requestType = 1);
            }
        }
        
        
        $currentuser = $permissionRequestModel->getCurrentUserId();
        $comments = $commentModel->listRequestComments($requestId,$requestType = 1);
        
        foreach ($comments as $comment)
        {
            $commentCreator = $commentModel->getCommentCreatorId($comment->id);
            if ($currentuser === $commentCreator) {
            
                $comment->iscreator = TRUE;
            }
            else {

                $comment->iscreator = FALSE;
            }
            
        }
        $this->view->requestComments = $comments;
        $this->view->commentForm = $commentForm;
    }

    public function deletecommentAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $commentModel = new Requests_Model_Comment($em);
        $request = $this->getRequest();
        $commentId = $request->id;
        $requestId = $commentModel->getcommentRequestId($commentId);
        $commentModel->deleteComment($commentId);

        $this->redirect("/requests/permission/show/id/$requestId");
    }

}
