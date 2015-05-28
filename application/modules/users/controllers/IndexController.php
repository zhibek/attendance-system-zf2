<?php

class Users_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // listing
        
        //number of items to be displayed per page
        $numberPerPage = 10.0 ;
        // get all databases entities
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $repository = $em->getRepository('Attendance\Entity\User');
               
        $paginator =new Zend_Paginator(new Attendance_Paginator_Doctrine($repository));
        // know the desired page and get specified entities
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        // set the paginator for the number of items to be displayed per page
        $paginator->setItemCountPerPage($numberPerPage);
        
        // know the number of pages
        
        $numberOfPages = $paginator->count();
        //create an array of page numbers
        $pageNumbers = array();
        foreach ( range(1, $numberOfPages) as $currentPageNumber )
        {
            $pageNumbers[]=array('number'=> $currentPageNumber);
        }
        
        $this->view->userList = $paginator;
        $this->view->pageNumbers = $pageNumbers;
        
    }
    
    public function editAction()
    {
        
    }
}