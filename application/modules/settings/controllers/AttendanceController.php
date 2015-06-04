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
        $form = new Settings_Form_AttendanceForm();
        $request = $this->getRequest();
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $attendanceInfo = $this->_request->getParams();
        $attendanceModel = new Settings_Model_Attendance($em);
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $attendanceModel->newVacation($attendanceInfo);
                $this->redirect('/settings/attendance/index');
            }
        }

        $this->view->form = $form;
    }

}
