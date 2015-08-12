<?php

/**
 * Description of DepartmentController
 *
 * @author ahmed
 */
class Settings_DepartmentsController extends Zend_Controller_Action
{

    function init()
    {
        //initalize somethinh here
    }

    public function indexAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $departmentModel = new Settings_Model_Department($em);
        $departments = $departmentModel->listDepartments();
        $this->view->departments = $departments;
    }

    public function newAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $departmentForm = new Settings_Form_DepartmentForm(array('em' => $em));
        $request = $this->getRequest();
        $departmentInfo = $this->_request->getParams();
        $departmentModel = new Settings_Model_Department($em);
        if ($request->isPost()) {
            if ($departmentForm->isValid($request->getPost())) {
                $departmentModel->newDepartment($departmentInfo);
                $this->redirect('/settings/departments/index');
            }
        }

        $this->view->departmentForm = $departmentForm;
    }

    public function editAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $departmentForm = new Settings_Form_DepartmentForm(array('em' => $em));
        $request = $this->getRequest();
        $departmentModel = new Settings_Model_Department($em, $request);
        $departmentModel->populateForm($departmentForm);
        $this->view->departmentForm = $departmentForm;

        if ($request->isPost()) {
            if ($departmentForm->isValid($request->getPost())) {
                $departmentInfo = $this->_request->getParams();
                $departmentModel->updateDepartment($departmentInfo);
                $this->redirect('/settings/departments/index');
            }
        }
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $departmentModel = new Settings_Model_Department($em, $request);
        $departmentModel->deactivateDepartment();
        $this->redirect('/settings/departments/index');
    }

}
