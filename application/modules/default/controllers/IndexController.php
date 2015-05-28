<?php

use \Application_Form_Registeration;

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
//        echo $this->url(array('module' => 'user', 
//                      'controller' => 'user', 
//                      'action' => 'index'));
        // get requested page number
        if ( $this->_request->getParam("page"))
        {
            $pageNumber = $this->_request->getParam("page");
        }
        else 
        {
            $pageNumber = 1;
        }    
         
        $em = $this->getInvokeArg('bootstrap')->getResource('entityManager');
        $repository = $em->getRepository('Attendance\Entity\User');
        $entitiesCount = sizeof($repository->findAll());
        //get number of pages
        $numberOfPages = ceil($entitiesCount/10.0);
        //create an array of page numbers
        $pageNumbers = array();
        foreach ( range(1, $numberOfPages) as $currentPageNumber )
        {
            $pageNumbers[]=array('number'=> $currentPageNumber);
        }
        //get specified entities
        $entities = $repository->findBy(array(),null,10, ($pageNumber-1)*10);//($pageNumber-1) for zero based count
        
        $this->view->userList = $entities;
        $this->view->pageNumbers = $pageNumbers;
        $this->view->pageNumber = $pageNumber;
        
        
        $form = new Application_Form_Registeration();
        $this -> view -> signUp = $form;
        
        
        
        
        
    }


    
   
    
    
    
    
}

