<?php

/**
 * Description of PermissionController
 *
 * @author Mohamed Ramadan
 */
class Requests_PermissionController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $form =  new Requests_Form_PermissionForm();
    }

}
