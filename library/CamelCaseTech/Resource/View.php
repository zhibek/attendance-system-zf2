<?php

class CamelCaseTech_Resource_View extends Zend_Application_Resource_View
{

    /**
     * Get view
     *
     * @return CamelCaseTech_View
     */
    public function getView()
    {
        if (null === $this->_view) {
            $this->_view = new CamelCaseTech_View($this->getOptions());
        }
        return $this->_view;
    }

}