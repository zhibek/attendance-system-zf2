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
            $storage = Zend_Auth::getInstance()->getIdentity();
            $list = $this->attendanceRecordsModel->filterByYear($dateFrom,$dateTo,$storage['id']);
        }else
        {
            $list = $this->attendanceRecordsModel->listAll();
        }
        
        foreach ($list as $currentRecord)
        {
            $currentRecord->signInDate = date_format($currentRecord->timeIn, 'Y-m-d');
            $currentRecord->signInTime = date_format($currentRecord->timeIn, 'H:i:s');
            $currentRecord->signOutTime = date_format($currentRecord->timeOut, 'H:i:s');
            $currentRecord->hourDifference = (int)$this->hourDifference($currentRecord->signInTime,$currentRecord->signOutTime);
        }
        
        $groupedList = $this->groupIntoLists($dateFrom,$dateTo,$list);
        
        //var_dump(json_encode($result));
        
        $this->view->filterForm = $filterForm;
        $this->view->list = $groupedList;
    }
    
    private function groupIntoLists($dateFrom,$dateTo,$list)
    {
        $result = array();
        //create a list of these dates
        $start    = (new DateTime($dateFrom))->modify('first day of this month');
        $end      = (new DateTime($dateTo))->modify('first day of this month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        
        foreach ($period as $dt) {
            $currentItem =  array(
                'counter' => 0,
                'date' => $dt->format("Y-F") ,
                'list' => $this->fillDateWithRecords($dt->format("Y-F"),$list),
            );
            
            $currentItem['counter'] = sizeof($currentItem['list']);            //$this->fillDateWithRecords($currentItem,$list);
            
            $result[] = $currentItem;
        }
        
        return $result;
    }

    private function fillDateWithRecords($currentDate,$list)
    {
        $fullList = array();
        
        foreach($list as $record)
        {
            if(date_format($record->timeIn,'Y-F') == $currentDate)
            {   
                $fullList[] = $record;
            }
        }
        
        return $fullList;
    }
    
    function hourDifference($firstTime,$lastTime) {
        $firstTime=strtotime($firstTime);
        $lastTime=strtotime($lastTime);
        $timeDiff=$lastTime-$firstTime;//in seconds
        return $timeDiff/60/60;//in minutes
    }
    

}
