<?php

class Default_Form_Signin extends Zend_Form
{

    function init()
    {

        $this->setMethod('POST');

        $this->addElement('text', 'username', array(
            'label' => 'Username',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(array('stringLength', false, array(1, 25))),
        ));
        $this->getElement('username')->setAttrib('class', 'form-control');

        $this->addElement('password', 'password', array(
            'label' => 'Password',
            'required' => true,
            'filters' => array('StringTrim'),
        ));
        $this->getElement('password')->setAttrib('class', 'form-control');
        $this->addElement('submit', 'login', array(
            'ignore' => true,
            'label' => 'Log in',
        ));
        $this->getElement('login')->setAttrib('class', 'btn btn-lg btn-success btn-block');
    }

}
