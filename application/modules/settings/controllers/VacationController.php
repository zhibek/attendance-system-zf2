<?php

/**
 * Description of VacationController
 *
 * @author ahmed
 */
class Settings_VacationController extends Zend_Controller_Action
{

    public function init()
    {
        //something
    }

    public function indexAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $vacationModel = new Settings_Model_Vacation($em);
        $vacations = $vacationModel->listAllVacations();
        $this->view->vacations = $vacations;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $vacationModel = new Settings_Model_Vacation($em, $request);
        $vacationModel->deactivateVacation();
        $this->redirect('/settings/vacation/index');
    }

    public function editAction()
    {
        $form = new Settings_Form_VacationForm();
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $vacationModel = new Settings_Model_Vacation($em, $request);
        $vacationModel->populateForm($form);
        $this->view->editForm = $form;

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $vacationInfo = $this->_request->getParams();
                $vacationModel->updateVacation($vacationInfo);
                $this->redirect('/settings/vacation/index');
            }
        }
    }

    public function newAction()
    {
        $form = new Settings_Form_VacationForm();
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $vacationInfo = $this->_request->getParams();
        $vacationModel = new Settings_Model_Vacation($em);
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $vacationModel->newVacation($vacationInfo);
                $this->redirect('/settings/vacation/index');
            }
        }

        $this->view->form = $form;
    }

}
