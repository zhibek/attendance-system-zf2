<?php

/**
 * Description of AttendanceController
 *
 * @author ahmed
 */
class Settings_AttendanceController extends Zend_Controller_Action
{

    public function init()
    {
        //something
    }

    public function indexAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $attendanceModel = new Settings_Model_Attendance($em);
        $Attendances = $attendanceModel->listAttendances();
        $this->view->attendances = $Attendances;
    }

    public function newAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $form = new Settings_Form_AttendanceForm(array('em' => $em));
        $request = $this->getRequest();
        $attendanceInfo = $this->_request->getParams();
        $attendanceModel = new Settings_Model_Attendance($em);
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $attendanceModel->newAttendance($attendanceInfo);
                $this->redirect('/settings/attendance/index');
            }
        }
        
        $this->view->form = $form;
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $attendanceModel = new Settings_Model_Attendance($em, $request);
        $attendanceModel->deactivateAttendance();
        $this->redirect('/settings/attendance/index');
    }

    public function editAction()
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $form = new Settings_Form_AttendanceForm(array('em' => $em));
        $request = $this->getRequest();
        $attendanceModel = new Settings_Model_Attendance($em, $request);
        $attendanceModel->populateForm($form);
//        unset($form->branch);
        $this->view->editForm = $form;

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $attendanceInfo = $this->_request->getParams();
                $attendanceModel->updateAttendance($attendanceInfo);
                $this->redirect('/settings/attendance/index');
            }
        }
    }

}
