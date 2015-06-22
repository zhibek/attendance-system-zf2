<?php

/**
 * Description of VacationController
 *
 * @author ahmed
 */
class Myattendance_AttendanceController extends Zend_Controller_Action {
    
    protected  $entityManager;


    public function init() {
        //something
        $this->entityManager = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $this->attendanceRecordsModel = new Myattendance_Model_AttendanceRecord($this->entityManager);
    }

    public function indexAction() {
        $filterForm = new Myattendance_Form_FilterByYearForm(null,$this->entityManager);
        $dateTo = $this->getParam('dateTo');
        $dateFrom = $this->getParam('dateFrom');
        if(isset($dateTo)&&isset($dateFrom))
        {
            $list = $this->attendanceRecordsModel->filterByYear($this->getParam('dateTo'),$this->getParam('dateFrom'));
        }else
        {
            $list = $this->attendanceRecordsModel->listAll();
        }
        
        var_dump(json_encode($list));

        $this->view->filterForm = $filterForm;
        $this->view->list = $list;
    }

    

}
