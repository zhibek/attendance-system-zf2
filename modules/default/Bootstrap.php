<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap {

    public function _initResourceLoader() {
        $this->getResourceLoader()->addResourceType('service', 'services/', 'Service');
//        $this->getResourceLoader()->addResourceType('model', 'models/', 'Model');
        
    }
    

}
