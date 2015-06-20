<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CamelCaseTech_Resource_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(\Zend_Controller_Request_Abstract $request)
    {
        parent::preDispatch($request);
        $auth = Zend_Auth::getInstance();
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;

        $acl = new Zend_Acl();
        // to have the acl object available in global storage
        Zend_Registry::set('acl', $acl);
        // creating roles
        $base = new Zend_Acl_Role('base');
        $employee = new Zend_Acl_Role('user');
        $hr = new Zend_Acl_Role('hr');
        $manager = new Zend_Acl_Role('manager');
        $admin = new Zend_Acl_Role('admin');
        // adding created roles to ACL
        $acl->addRole($base, null);
        $acl->addRole($employee, $base);
        $acl->addRole($hr, $base);
        $acl->addRole($manager, $base);
        $acl->addRole($admin);
        //grant all for admin
        $acl->allow($admin);
        // creating resources
        $resources = 'requests-myrequests';
        $acl->addResource('requests-myrequests');
        // giving roles thier privileges in /requests/myrequests
        $acl->allow($base, $resources, 'comment');
        $acl->allow($employee, $resources, 'cancel');
        $acl->allow($hr, $resources, array('approve','decline'));
        $acl->allow($manager, $resources,  array('approve','decline'));

    }

}
