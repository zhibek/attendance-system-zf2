<?php

class CamelCaseTech_Resource_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {
        parent::preDispatch($request);
    }
}