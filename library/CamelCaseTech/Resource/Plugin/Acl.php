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
        $storage = Zend_Auth::getInstance()->getIdentity();
        $this->role = $storage['rolename'];
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;


        // creating roles
//        $base = new Zend_Acl_Role('base');
//        $employee = new Zend_Acl_Role('Employee');
//        $hr = new Zend_Acl_Role('HR');
//        $manager = new Zend_Acl_Role('Manager');
//        $admin = new Zend_Acl_Role('Admin');
//        // adding created roles to ACL
//        $acl->addRole($base, null);
//        $acl->addRole($employee, $base);
//        $acl->addRole($hr, $base);
//        $acl->addRole($manager, $base);
//        $acl->addRole($admin);
//        //grant all for admin
//        $acl->allow($admin);
//        // creating resources
//        $resources = 'requests-myrequests';
//        $acl->addResource('requests-myrequests');
//        $acl->addResource('users-module');
//        $acl->addResource('settings-module');
//        // giving roles thier privileges in /requests/myrequests
//        $acl->allow($base, $resources, 'comment');
//        $acl->allow($employee, $resources, 'cancel');
//        $acl->allow($hr, $resources, array('approve','decline','viewall'));
//        $acl->allow($manager, $resources,  array('approve','decline','viewall'));
        $config = Zend_Config_Yaml::decode(file_get_contents(
                                APPLICATION_PATH . '/configs/acl.yaml'
        ));
        $acl = new Zend_Acl();
        
        // to have the acl object available in global storage
//        Zend_Registry::set('acl', $acl);

        foreach ($config['roles'] as $role) {
            $acl->addRole($role);
        }
        foreach ($config['resources'] as $resource) {
            $acl->addResource($resource);
        }
//        var_dump($config['blacklist']);exit();
        if (count($config['whitelist'])) {
            foreach ($config['whitelist'] as $rule) {
                // Set undefined indexes to null to prevent php_notice
                if (!isset($rule['roles'])) {
                    $rule['roles'] = null;
                }
                if (!isset($rule['resources'])) {
                    $rule['resources'] = null;
                }
                if (!isset($rule['privileges'])) {
                    $rule['privileges'] = null;
                }
                $acl->allow($rule['roles'], $rule['resources'], $rule['privileges']);
            }
        }

        if (count($config['blacklist'])) {
            foreach ($config['blacklist'] as $rule) {
                // Set undefined indexes to null to prevent php_notice
                if (!isset($rule['roles'])) {
                    $rule['roles'] = null;
                }
                if (!isset($rule['resources'])) {
                    $rule['resources'] = null;
                }
                if (!isset($rule['privileges'])) {
                    $rule['privileges'] = null;
                }
                $acl->deny($rule['roles'], $rule['resources'], $rule['privileges']);
            }
        }

        // hide modules that are not allowed
        if ($acl->isAllowed($this->role, 'users-module')) {
            $view->visibleUserModule = TRUE;
        } else {
            $view->visibleUserModule = FALSE;
        }
        if ($acl->isAllowed($this->role, 'settings-module')) {
            $view->visibleSettingsModule = TRUE;
        } else {
            $view->visibleSettingsModule = FALSE;
        }
    
        Zend_Registry::set('acl', $acl);
        }

}
