<?php

/**
 * Description of PositionController
 *
 * @author ahmed
 */
class Settings_PositionController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $positionModel = new Settings_Model_Position($em);
        $positions = $positionModel->listPositions();
        $this->view->positions = $positions;
    }

    public function newAction()
    {
        $positionForm = new Settings_Form_PositionForm();
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $positionInfo = $this->_request->getParams();
        $positionModel = new Settings_Model_Position($em);
        if ($request->isPost()) {
            if ($positionForm->isValid($request->getPost())) {
                $positionModel->newPosition($positionInfo);
                $this->redirect('/settings/position/index');
            }
        }

        $this->view->positionForm = $positionForm;
    }
    public function editAction()
    {
        $positionForm = new Settings_Form_PositionForm();
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $positionModel = new Settings_Model_Position($em, $request);
        $positionModel->populateForm($positionForm);
        $this->view->positionForm = $positionForm;

        if ($request->isPost()) {
            if ($positionForm->isValid($request->getPost())) {
                $positionInfo = $this->_request->getParams();
                $positionModel->updatePosition($positionInfo);
                $this->redirect('/settings/position/index');
            }
        }
    }
        public function deleteAction()
    {
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $PositionModel = new Settings_Model_Position($em, $request);
        $PositionModel->deactivatePosition();
        $this->redirect('/settings/position/index');
    }

}
