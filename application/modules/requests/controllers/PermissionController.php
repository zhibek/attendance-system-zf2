<?php

/**
 * Description of PermissionController
 *
 * @author Moataz
 */
class Requests_PermissionController extends Zend_Controller_Action
{
    public function init() {
        $this->entityManager = $this->getInvokeArg('bootstrap')->getResource('entityManager');
    }

    public function indexAction()
    {
        
        
        
    }

}
