<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Users_Model_User
{

    protected $paginator = NULL;
    
    protected $numberPerPage = 10.0 ;
    
    public function __construct($em) {
        $repository = $em->getRepository('Attendance\Entity\User');
        $this->paginator =new Zend_Paginator(new Attendance_Paginator_Doctrine($repository));
    }
    
    public function setPage($currentPage)
    {
        $this->paginator->setCurrentPageNumber($currentPage);
    }
    
    public function setNUmberPerPage($numberPerPage)
    {
        $this->numberPerPage = $numberPerPage;
    }
    
    public function setItemCountPerPage($numberPerPage)
    {
        $this->paginator->setItemCountPerPage($numberPerPage);
    }
    
    public function getNumberOfPages()
    {
        return (int)$this->paginator->count();
    }
    
    public function getCurrentItems()
    {
        return $this->paginator;
    }
    
    // My Helper Functions starts
    public function getBranchById($branchId)
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $branch = $em->getReposatory('\Attendance\Entity\Branch')->find($branchId)->toArray();
        return $branch[0];
    }
    
    public function getPositionById($positionId)
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $position = $em->getReposatory('\Attendance\Entity\Position')->find($positionId)->toArray();
        return $position[0];
    }
    
    public function getDepartmentById($departmentId)
    {
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $department = $em->getReposatory('\Attendance\Entity\Department')->find($departmentId)->toArray();
        return $department[0];
    }
    // My Helper functions ends
    
    
    
    
}

