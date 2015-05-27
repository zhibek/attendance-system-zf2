<?php

class Users_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // listing
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $repository = $em->getRepository('Attendance\Entity\User');
        $entities = $repository->findAll();
        $paginator = Zend_Paginator::factory($entities);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        
        
        $entitiesCount = sizeof($entities);
        $numberOfPages = ceil($entitiesCount/10.0);
        //create an array of page numbers
        $pageNumbers = array();
        foreach ( range(1, $numberOfPages) as $currentPageNumber )
        {
            $pageNumbers[]=array('number'=> $currentPageNumber);
        }
        //get specified entities
        
        $this->view->userList = $paginator;
        $this->view->pageNumbers = $pageNumbers;
        
    }
    
    public function editAction()
    {
        
    }
}