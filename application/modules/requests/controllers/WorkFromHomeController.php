<?php

/**
 * Description of WorkFromHomeController
 *
 * @author Ahmed
 */
class Requests_WorkFromHomeController extends Zend_Controller_Action
{

    public function indexAction()
    {
        
    }
    
    public function newAction(){
        $form= new Requests_Form_WorkFromHome();
        
        
        
        
        
        $this->view->form=$form;
    }

}
