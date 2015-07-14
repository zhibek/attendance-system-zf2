<?php

/**
 * Description of BranchesController
 *
 * @author AbdEl-Moneim
 */
class Settings_BranchesController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $em            = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $branchesModel = new Settings_Model_Branches($em);
        $branch        = $branchesModel->BranchStatus();
        $branches      = $branchesModel->listBranches();
        $this->view->branches = $branches;
    }

    public function newAction()
    {
        $em            = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $branchesForm  = new Settings_Form_BranchesForm(array('em' => $em));
        $request       = $this->getRequest();
        $branchesInfo  = $this->_request->getParams();
        $branchesModel = new Settings_Model_Branches($em);

        if ($request->isPost()) {
            if ($branchesForm->isValid($request->getPost())) {
                $branchesModel->newBranches($branchesInfo);
                $this->redirect('/settings/branches/index');
            }
        }

        $this->view->branchesForm = $branchesForm;
    }

    public function editAction()
    {

        $em            = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $branchesForm  = new Settings_Form_BranchesForm(array('em' => $em));
        $request       = $this->getRequest();
        $branchesModel = new Settings_Model_Branches($em, $request);
        $branchesModel->populateForm($branchesForm);
        $this->view->branchesForm = $branchesForm;

        if ($request->isPost()) {
            if ($branchesForm->isValid($request->getPost())) {
                $branchesInfo = $this->_request->getParams();
                $branchesModel->updateBranches($branchesInfo);
                $this->redirect('/settings/branches/index');
            }
        }
    }

    public function deleteAction()
    {
        $request       = $this->getRequest();
        $em            = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $branchesModel = new Settings_Model_Branches($em, $request);
        $branchesModel->deactivateBranches();
        $this->redirect('/settings/branches/index');
    }
}
