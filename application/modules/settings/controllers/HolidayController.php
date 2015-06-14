<?php

/**
 * Description of VacationController
 *
 * @author ahmed
 */
class Settings_HolidayController extends Zend_Controller_Action {
    
    protected  $entityManager;


    public function init() {
        //something
        $this->entityManager = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $this->holidayModel = new Settings_Model_Holiday($this->entityManager);
    }

    public function indexAction() {
        $filterForm = new Settings_Form_FilterByYearForm(null,$this->entityManager);
        if($this->getParam('year'))
        {
            $holidayList = $this->holidayModel->filterByYear($this->getParam('year'));
        }else
        {
            $holidayList = $this->holidayModel->listAll();
        }
        foreach ($holidayList as $holiday) {
            $holiday->dateFrom = date_format($holiday->dateFrom, 'm/d/Y');
            $holiday->dateTo = date_format($holiday->dateTo, 'm/d/Y');
        }
        $this->view->filterForm = $filterForm;
        $this->view->holidayList = $holidayList;
    }

    public function deleteAction() {

        $this->holidayModel->deactivateHoilday($this->_getParam('id'));
        $this->redirect('/settings/holiday/index');
    }

    public function editAction() {
        $form = new Settings_Form_HolidayForm();
        $request = $this->getRequest();
        $this->holidayModel->populateForm($form, $this->_getParam('id'));
        $this->view->editForm = $form;

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $holidayInfo = $this->_request->getParams();
                $this->holidayModel->updateHoliday($holidayInfo);
                $this->redirect('/settings/holiday/index');
            }
        }
    }

    public function newAction() {
        $form = new Settings_Form_HolidayForm();
        $request = $this->getRequest();


        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {

                $holidayInfo = $this->_request->getParams();

                //validate dates
                $dateFrom = new DateTime($holidayInfo['dateFrom']);
                $dateTo = new DateTime($holidayInfo['dateTo']);
                if ($dateFrom > $dateTo) {
                    $form->getElement('dateTo')->addErrors(array('To Date: should be more than From Date:'));
                } else {
                    $this->holidayModel->newHoliday($holidayInfo);
                    $this->redirect('/settings/holiday/index');
                }
            }
        }

        $this->view->form = $form;
    }

}
