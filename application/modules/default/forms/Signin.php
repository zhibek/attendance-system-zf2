<?php

class Default_Form_Signin extends Zend_Form {
    
    function init() {

        $this->setMethod('POST');

        $this->addElement('text', 'username', array(
            'label' => 'Username',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(array('stringLength', false, array(1, 25))),
        ));

        $this->addElement('password', 'password', array(
            'label' => 'Password',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(array('stringLength', false, array(8, 25))),
        ));

        $this->addElement('submit', 'login', array(
            'ignore' => true,
            'label' => 'Log in',
        ));
    }

}
